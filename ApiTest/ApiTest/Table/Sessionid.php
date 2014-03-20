<?php
class Table_Sessionid extends Core_Db_ApiTable{

	protected $_tablename = 'user_sessionid';
	
	protected $_pk = 'id';
	/**
	 * @return Service_Album
	 */
	public static function getInstance() {
		return parent::getInstance ();
	}
	
	/**
	 * 根据用户ID和Identify查询
	 * @param $userid 用户ID
	 * @param $indentify
	 * @return array
	 */
	public  function getUserByUserid($userid,$identify){
		 $rs = $this->getQuery()->where('user_id = ?', $userid)
		       ->where('imei = ?',$identify)
		       ->fetch();
		 return $rs;
	}
	/**
	 * 查询用户全部sessionID
	 * @param $userid 用户ID
	 * @param array
	 */
	public  function getSessionIdByUid($userid){
		$rs = $this->getQuery()->where('user_id = ?', $userid)->fetchAll();
		return $rs;
	}
}