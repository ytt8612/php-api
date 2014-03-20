<?php
/**
 * 登陆注册处理类
 * @author 严廷廷
 */

class Service_Security extends Core_ApiService {

	/**
	 * @return Service_Security
	 */
	public static function getInstance() {
		return parent::getInstance();
	}
	/**
	 * 手机发送验证码
	 * @param $phone 手机号码
	 * @param $userid 用户id
	 */
	public function sendAuthCode($phone,$userid=0){
		
		$uid = $userid;
		$now = date('Y-m-d H:i:s');
		if($userid){
		$send_num = 1;
		if (! empty($send_num) &&
				Lang_Zh_Common::AUTH_CODE_MAX <= $send_num['num']) {
			return array(
					'send' => 2
			);
		}
		}
		/**
		 * **********开发环境发短讯************************
		*/
			$auth_code = Lib_Util::getRandStr(4);
		  //$arrRets = Lib_Util::sendSms($phone, '你的验证码为：' . $auth_code);
		/**
		 * **********开发环境发短讯************************
		*/
			$kind = $userid ? 1 :0;
		  $arrRets = true;
		 if(!empty($arrRets)){
		 	 $code_date = array('uid'=>$userid,'phone_num'=>$phone,'auth_code'=>$auth_code,'send_time'=>$now,'kind'=>$kind);
	     $id= Table_UserAuthcode::getInstance()->insert($code_date);
		 }
	
		return isset($id) && $id ? true : false;
	}
	/**
	 * 手机验证码验证信息
	 * @param $phone 手机号码
	 * @param $authcode 验证码
	 */
	public function verifyAuthCode($phone,$authcode,$kind){
		$auth = Table_UserAuthcode::getInstance()->getAuthcodeByPhone($phone);
		if(!empty($auth) && $authcode == $auth['code']){
			return array(
					'verifyed' => 1,
			);
		}
		return false;
	}
  /**
   * 用户登录函数
   * @param $username  用户名
	 * @param $password 密码
	 * return array
   */
	public function login($username,$password){
		$is_mail = Lib_Util::is_email($username);
		$is_mobile = Lib_Util::is_mobile($username);
		if($is_mail){
			$user_info = Table_Userinfo::getInstance()->getUserInfoByEmail($username);
			if($user_info)$user = Table_User::getInstance()->find($user_info['user_id']);
		}elseif($is_mobile){
			$user_info = Table_Userinfo::getInstance()->getUserInfoByPhone($username);
			if($user_info)$user = Table_User::getInstance()->find($user_info['user_id']);
		}else{
			$user = Table_User::getInstance()->getUserByName($username);
			if($user)$user_info = Table_Userinfo::getInstance()->find($user['user_id']);
		}
		$password = md5($password);
		if($user ){
			if ($user['passwd']==$password){
				//登录成功后的逻辑
				$sid = $this->loginSessionId($user['user_id']);
				Core_ApiRequest::getInstance()->setSessID($sid);
				setcookie('sid',$sid);
				return $user_info;
			}
			return array('code'=>103,'msg'=>'密码不正确！');
		}
		return array('code'=>102,'msg'=>'账号不存在！');
	}
	/**
	 * 用户注册函数
	 * @param $username  用户名
	 * @param $password 密码
	 * @param $email 邮箱
	 * @param $phone_num 电话
	 * @return $id
	 */
	public  function register($username,$password,$email,$phone_num){
		 $password = $password ? $password : '123456';
		 $password = md5($password);
		 $user=array(
		 		 'username'=>$username,
		 		 'passwd'=>$password,
		 		 'lastlogin'=>date('y-m-d H:i:s')
		 		);
		 $user_id = Table_User::getInstance()->insert($user);
		 if($user_id){
		 	//加入未验证用户信息
		 	$user_info = array(
		 			 'user_id'=>$user_id,
		 			 'username'=>$username,
		 			 'email'=>$email,
		 			 'phone_num'=>$phone_num,
		 			 'status'=>0
		 			);
		 	$rs = Table_Userinfo::getInstance()->insert($user_info);
		 	if(!$rs)Table_User::getInstance()->delete($user_id);
		 }
		 return $user_id; 
	}

	/**
	 * 登录生成sessionid方法
	 *
	 * @return str
	 */
	public function loginSessionId ($userid)
	{
		$dentify = Core_ApiRequest::getInstance()->getIdentify();
		$sessinfo =Table_Sessionid::getInstance()->getUserByUserid($userid,$dentify);
		if (! empty($sessinfo)) {
			$key = $sessinfo['sint'] + 1;
			if ($key > 100) {
				$key = 1;
			}
		Table_Sessionid::getInstance()->update(array(
					'id' => $sessinfo['id'],
					'sint' => $key
			));
		} else {
			$key = 1;
		}
	
		$user =  Table_Userinfo::getInstance()->find($userid);
		$nick = $user['username'];
		$content = "userid=$userid;username=" . $nick . ";r=$key;ts=" .time();
		$sessid = Lib_Util::encrypt($content);
		if (empty($sessinfo)) {
			$data = array(
					'user_id' => $userid,
					'sint' => $key,
					'session' => $sessid,
					'imei' => Core_ApiRequest::getInstance()->getIdentify()
			);
			Table_Sessionid::getInstance()->insert($data);
		}
		//$mem =  new Memcache();
		//$mem->connect("10.21.118.243", 60000);
		$mem = new Mem();
		$key = 'SESSID_' . $userid . '_' .Core_ApiRequest::getInstance()->getIdentify();
		$mem->delete($key);
		$mem->set($key, $sessid, 0, 24 * 3600);
		return $sessid;
	}
	/**
	 * 纯获取sessionid信息方法
	 *
	 * @return array
	 */
	public function getSessionIdInfo ($sid)
	{
		if (trim($sid) == '') {
			return false;
		}
		$content = Lib_Util::decrypt($sid);
		$ret = false;
		$content = explode(";", $content);
		if (count($content) > 1) {
			$tempRet = array();
			$isFailed = false;
			foreach ($content as $v) {
				$vs = explode("=", $v);
				if (count($vs) !== 2) {
					$isFailed = true;
					break;
				} else {
					$tempRet[$vs[0]] = $vs[1];
				}
			}
	
			if (! $isFailed) {
				$ret = $tempRet;
			}
		}
		return $ret;
	}
	/**
	 * 获取sessionid信息方法,并带有更新KEY功能
	 *
	 * @return array
	 */
	public function getInfoFromSessionId ($sid)
	{
		if (trim($sid) == '') {
			return false;
		}
		$content = Lib_Util::decrypt($sid);
		$ret = false;
		$content = explode(";", $content);
		if (count($content) > 1) {
			$tempRet = array();
			$isFailed = false;
			foreach ($content as $v) {
				$vs = explode("=", $v);
				if (count($vs) !== 2) {
					$isFailed = true;
					break;
				} else {
					$tempRet[$vs[0]] = $vs[1];
				}
			}
	
			if (! $isFailed) {
				$ret = $tempRet;
			}
			// 本地Session 过期暂时注视
			// $mem =  new Memcache();
		  // $mem->connect("10.21.118.243", 60000);
		   $mem = new Mem();
			 $key = 'SESSID_' . $ret['userid'] . '_' .
			Core_ApiRequest::getInstance()->getIdentify();
			$memsessid = $mem->get($key);
			if (empty($memsessid)) {
			$sessinfo =Table_Sessionid::getInstance()->getUserByUserid($ret['userid'],Core_ApiRequest::getInstance()->getIdentify());
			if (! empty($sessinfo)) {
			if ($ret['r'] == $sessinfo['sint']) {
			$key = $sessinfo['sint'] + 1;
			if ($key > 100) {
			$key = 1;
			}
			$sid = $this->generateSessionId($ret['userid'], $key);
			Table_Sessionid::getInstance()->update(
					array(
							'id' => $sessinfo['id'],
							'sint' => $key,
							'session' => $sid
					));
			Core_ApiRequest::getInstance()->setSessID($sid);
			} else {
			return false;
			}
			}
			} else {
			if ($memsessid != $sid) {
			return false;
			}
			}   
		}
		return $ret;
	}
	
	/**
	 * 生成sessionid方法
	 *
	 * @return str
	 */
	public function generateSessionId ($userid, $upchar)
	{
		$user =Table_Userinfo::getInstance()->find($userid);
		$content = "userid=$userid;username=" . $user['username'] . ";r=$upchar;ts=" .
		time();
		$sessid = Lib_Util::encrypt($content);
		//$mem =  new Memcache();
		//$mem->connect("10.21.118.243", 60000);
		$mem = new Mem();
		$key = 'SESSID_' . $userid . '_' .
		Core_ApiRequest::getInstance()->getIdentify();
		$mem->set($key, $sessid, 0, 24 * 3600);
		return $sessid;
	}
	
	// 全部删除用户的SESSION，用在用户更改密码后
	public function removeAllSession ($userid)
	{
		$sessinfo = Table_Sessionid::getInstance()->getSessionIdByUid($userid);
		//$mem =  new Memcache();
		//$mem->connect("10.21.118.243", 60000);
		$mem = new Mem();
		if (! empty($sessinfo)) {
			foreach ($sessinfo as $f) {
				$key = 'SESSID_' . $userid . '_' . $f['imei'];
				$mem->remove($key);
				$delids[] = $f['id'];
				Table_Sessionid::getInstance()->delete($sessinfo['id']);
			}
		}
	}
	
	/**
	 * 登出删除sessionid方法
	 *
	 * @return str
	 */
	public function removeSessionId ($userid)
	{
		$sessinfo = Table_Sessionid::getInstance()->getUserByUserid($userid,Core_ApiRequest::getInstance()->getIdentify());
		if (! empty($sessinfo)) {
			Table_Sessionid::getInstance()->delete($sessinfo['id']);
		}
		//$mem =  new Memcache();
		//$mem->connect("10.21.118.243", 60000);
		$mem = new Mem();
		$key = 'SESSID_' . $userid . '_' .
				Core_ApiRequest::getInstance()->getIdentify();
		$mem->remove($key);
	
		return true;
	}
	
	
 }