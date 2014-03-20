<?php

class Core_ApiCli extends Core_ApiSingleton {

    protected static $_json;
    protected $_cmd;
    protected $_sessID;
    protected $_params = array();


    public static function getInstance() {
        return parent::getInstance();
    }

    public static function getJson() {
        return self::$_json;
    }

    protected function __construct() {
        $this->_httpHeaders = $this->_parseHttpHeaders();

        $json = isset($_REQUEST['json']) ? $_REQUEST['json'] : '';
//        print_r($json);
//        exit();
        if ($json) {
            if (preg_match("/%22do%22%/", $json)) {
                $json = urldecode($json);
            }
            $json = json_decode($json, true);
            if (JSON_ERROR_NONE !== json_last_error()) {
                $json = '';
            }
        }

        if (!$json) {
            throw new BadMethodCallException('Invalid Request');
        }
        if (empty($json['do'])) {
            throw new BadMethodCallException('Invalid DO');
        }
        

        self::$_json = $json;
        $this->_cmd = $json['do'];
    	if (preg_match("/%3D/", $json['sessID'])) {
            $json['sessID'] = urldecode($json['sessID']);
        }
        $this->_sessID = $json['sessID'];
        if (!empty($json['data'])) {
            $this->_params = $json['data'];
	    }
    }


    public function getParams() {
        return $this->_params;
    }

    public function getParam($key, $default = null) {
        if ($this->hasParam($key)) {
            return $this->_params[$key];
        } else {
            return $default;
        }
    }

    public function hasParam($key) {
        return isset($this->_params[$key]);
    }

    public function getCmd() {
        return $this->_cmd;
    }
    
    
	public function getSessID() {
        return $this->_sessID;
    }
    
	public function setSessID($sid) {
        $this->_sessID = $sid;
    }
    

    protected function _parseHttpHeaders() {
        $items = array(
            'REMOTE_ADDR',
            'REQUEST_TIME',
            'HTTP_USER_AGENT',
            'REQUEST_METHOD',
            'HTTP_REFERER',
            'CONTENT_TYPE',
            //User define http headers
            //!IMPORTANT! char '_' is not allowed in HTTP 1.1 by default
//            'YIBAN_AUTHORIZATION',
//            'YIBAN_UA',
        );
        $ori_headers = array_merge($_SERVER, $_ENV);
        $parsed_headers = array();
        foreach ($items as $key) {
            $convert_key = strtr(strtolower($key), array('http_' => '', '_' => '-'));
            if (!empty($ori_headers[$key])) {
                $parsed_headers[$convert_key] = $ori_headers[$key];
            }
        }
        return $parsed_headers;
    }

    public function getHttpHeaders() {
        return $this->_httpHeaders;
    }

    public function getHttpHeader($item) {
        return isset($this->_httpHeaders[$item]) ? $this->_httpHeaders[$item] : null;
    }

}