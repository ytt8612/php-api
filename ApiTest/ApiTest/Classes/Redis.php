<?php
/**
 * redis功能类
 * @package Lib
 * @desc 对php-redis扩展的轻封装
 * @name Lib_Redis
 * @copyright Copyright(c) 2013, Yiban.cn Inc
 * @author song <zousong@yiban.cns>
 * @link https://github.com/nicolasff/phpredis
 */

class Lib_Redis {
	
	/**
	 * redis object
	 * @var object
	 */
	public $_redis = null;
	
	/**
	 * @var array()
	 */
	protected static $_config = array();
	
	/**
	 * @var bool
	 */
	public static $_enable_profiler = false;
	
	/**
	 * store profile data
	 * @var array()
	 */
	public static $_profiler = array();
	
	/**
	 * instance of Lib_Redis
	 * @var Lib_Redis
	 */
	public static $_instance = array();
	
	/**
	 * get instance of Lib_Redis
	 * @return Lib_Redis
	 */
	public static function getInstance($group='default'){
		if (!isset(self::$_instance[$group]) || !self::$_instance[$group] instanceof Lib_Redis) {
			self::$_instance[$group] = new Lib_Redis(self::$_config[$group]['host'], self::$_config[$group]['port']);
		}
		return self::$_instance[$group];
	}

	/**
	 * generate redis object and connect redis server
	 * @param string $host
	 * @param int $port
	 * @param int $timeout default 0
	 * @return bool
	 */
	private function __construct($host, $port, $timeout = 2){
		$this->_redis = new Redis();
		$this->_redis->connect($host, $port, $timeout);
		$this->_redis->select(2);
		$this->_redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
		return $this->_redis;
	}
	
	/**
	 * set configs
	 * @param array $configs
	 */
	public static function setConfig($configs){
		self::$_config = $configs;
	}
	
	/**
	 * enable Profiler
	 */
	public static function enableProfiler(){
		self::$_enable_profiler = true;
	}
	
	/**
	 * get Lib_Redis's $_profiler prototype
	 */
	public function getProfiler(){
		return self::$_profiler;
	}
	
	
	/**
	 * call redis methods
	 * @param string $function_name
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($function_name, $arguments){
		$start_time = Tools::getMicrotime();
		$result = call_user_func_array(array($this->_redis, $function_name), $arguments);
		if (self::$_enable_profiler) self::logCommands($function_name, $arguments, $start_time);
		return $result;
	}
	
	/**
	 * log every memcache commands with arguments and start time
	 * @param string $cmd
	 * @param array $arguments
	 * @param float $start_time
	 */
	protected static function logCommands($cmd, $arguments, $start_time){
		$data = array(
			'cmd' => $cmd,
			'args' => $arguments ,
			'start_time' => $start_time,
			'end_time' => Tools::getMicrotime()
		);
		self::$_profiler[] = $data;
	}
}

//EOF