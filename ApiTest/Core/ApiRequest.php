<?php

class Core_ApiRequest extends Core_ApiSingleton {

    protected static $_json;
    protected $_cmd;
    protected $_sessID;
    protected $_params = array();
    protected $_httpHeaders = array();
    protected $_ct;	 //客户端类型：1: ios，2: android
    protected $_rv;	 //渠道号
    protected $_v;	 //客户端版本号
    protected $_apn;	 //客户端网络接入点
    protected $_identify;	 //手机imei号
    protected $token; //iphone手机 token值
    protected $_device; //移动设备型号
    protected $_sversion; //移动设备系统版本号
    
    protected $_istask=false;	 //异步任务
    
    protected $_files = array();

    /**
     *
     * @return Core_Request
     */
    public static function getInstance() {
        return parent::getInstance();
    }

    public static function getJson() {
        return self::$_json;
    }

    protected function __construct() {
        $this->_httpHeaders = $this->_parseHttpHeaders();
        $jsonstr = isset($_REQUEST['json']) ? $_REQUEST['json'] : '';
        if ($jsonstr) {
            if (preg_match("/%22do%22%/", $jsonstr)) {
                $json = urldecode($jsonstr);
            }else{
            	$json = $jsonstr;
            }
            $json = json_decode($json, true);
            if (JSON_ERROR_NONE !== json_last_error()) {
                $json = '';
            }
        }
        //print_r($jsonstr);
        //exit();

        if (!$json) {
            throw new BadMethodCallException('Invalid Request');
        }

        if (empty($json['do'])) {
            throw new BadMethodCallException('Invalid DO');
        }
        
        if($json['do']!='site_crash'){
	    	$sig = isset($_REQUEST['sig']) ? $_REQUEST['sig'] : '';
		    if (!$sig) {
		        throw new BadMethodCallException('Where is sig?');
		    }
		    $veristr = md5($jsonstr);
		    if($sig!=$veristr){
		    	throw new BadMethodCallException('Invalid Request data');
		    }
        }
        if(!empty($json['error'])&&$json['error']==1){
        	$ran = rand(1,5);
        	switch ($ran){
        		case 1:
        			echo json_encode(array('response' => '101', 'message' =>iconv("GBK","UTF-8",'总之是失败了，怎么滴吧')));
        			break;
        		case 2:
        			echo json_encode(array('response' => '105', 'message' =>iconv("GBK","UTF-8",'上传参数错误，传的是嘛玩意儿啊？')));
        			break;
        		case 3:
        			echo json_encode(array('response' => '106', 'message' =>iconv("GBK","UTF-8",'sessID过期多年，好久没用了吧')));
        			break;
        		case 4:
        			echo json_encode(array('response' => '140', 'message' =>iconv("GBK","UTF-8",'让你丫刷')));
        			break;
        		case 5:
        			echo json_encode(array('response' => '180', 'message' =>iconv("GBK","UTF-8",'哪来的山寨货？')));
        			break;
        		default:
        			echo json_encode(array('response' => '101', 'message' =>iconv("GBK","UTF-8",'总之是失败了，怎么滴吧')));
        			break;
        	}
        	exit();
        }

        self::$_json = $json;
        $this->_cmd = $json['do'];
        $this->_ct = $json['ct'];
        $this->_rv = $json['rv'];
        $this->_v = $json['v'];
        $this->_apn = isset($json['apn']) ? $json['apn'] : '';
        $this->_identify = isset($json['identify']) ? $json['identify'] : '';
        $this->_token = isset($json['token']) ? $json['token']:'';
        $this->_device = isset($json['device']) ? $json['device']:'';
        $this->_sversion = isset($json['sversion']) ? $json['sversion']:'';
        $this->_istask = isset($json['istask'])?$json['istask']:false;
    	if (preg_match("/%/", $json['sessID'])) {
            $json['sessID'] = urldecode($json['sessID']);
        }
        $this->_sessID = $json['sessID'];
        $this->_identify = $json['identify'];
        if (!empty($json['data'])) {
            $this->_params = $json['data'];
            if(isset($this -> _params['content'])){
            	//过滤信息中的/f 特殊字符串
            	$this -> _params['content'] = str_replace('/f', '', $this -> _params['content']);
            }
	    }

        $this->_fixFiles();
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
    
	public function getCt() {
        return $this->_ct;
    }
    
	public function getRv() {
        return $this->_rv;
    }
    
	public function getVision() {
        return $this->_v;
    }
    
	public function getApn() {
        return $this->_apn;
    }
    
	public function getIdentify() {
        return $this->_identify;
    }
    
	public function getSessID() {
        return $this->_sessID;
    }
  public function getToken(){
    return $this->_token;	 
   }  
	public function setSessID($sid) {
        $this->_sessID = $sid;
    }

	public function isTask() {
        return $this->_istask;
    }
    
	public function setIsTask($istask) {
        $this->_istask = $istask;
    }

    protected function _parseHttpHeaders() {
        $items = array(
			      'HTTP_HOST',
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

    public function isMultipart() {
        return $this->isPost() && (strpos($this->getHttpHeader('content-type'), "multipart/form-data") !== false);
    }

    protected function _fixFiles($top = true) {
        if (!$this->isMultipart()) {
            return;
        }
        $files = array();
        foreach ($_FILES as $name => $file) {
            if ($top) {
		    	      $filenames = $file['tmp_name'];
                $sub_name = $file['name'];
            } else {
		    	      $filename =$name;
                $sub_name = $name;
            }
            if(is_array($filenames)){
            	foreach ($filenames as $filename){
            		if(!$this->isImage($filename)){
            			throw new BadMethodCallException('Invalid Image data');
            		}
            	}
            }else{
            	if(!$this->isImage($filenames)){
            		throw new BadMethodCallException('Invalid Image data');
            	}
            	}
           /*  if (is_array($sub_name)) {
                foreach (array_keys($sub_name) as $key) {
                    $files[$name][$key] = array(
                        'name' => $file['name'][$key],
                        'type' => $file['type'][$key],
                        'tmp_name' => $file['tmp_name'][$key],
                        'error' => $file['error'][$key],
                        'size' => $file['size'][$key],
                    );
                    $files[$name] = $this->_fixFiles($files[$name], FALSE);
                }
            } else {
                $files[$name] = $file;
            } */
            $files[$name] = $file;
        }
        $this->_files = $files;
    }

    public function isMethod($method) {
        return strtoupper($method) == strtoupper($this->getHttpHeader('request-method'));
    }

    public function isPost() {
        return $this->isMethod('POST');
    }

    public function getFiles() {
        return $this->_files;
    }
    
	/**
	 * 
	 * 判断是否是图片
	 * @param string $filename 图片地址
	 */
	function isImage($filename) {
		if(!is_file($filename)) {
			return false;
		}
		if(($fh = @fopen($filename, "rb"))) {
			$strInfo = unpack("C2chars", fread($fh,2));
			fclose($fh);
			$fileTypes = array(255216=>'jpg',7173=>'gif',6677=>'jpeg',13780=>'png',);
			if(!isset($fileTypes[intval($strInfo['chars1'] . $strInfo['chars2'])])){
				return false;
			}
		}
		return true;
	}

}

