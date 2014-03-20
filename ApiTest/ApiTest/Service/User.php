<?php
class Service_User extends Core_ApiService {
	
	/**
	 *
	 * @return Service_User
	 */
	public static function getInstance() {
		return parent::getInstance ();
	}
	/**
	 * 获取好友列表
	 * @param $userid 用户ID
	 * @return array
	 */
	public function getAllFriendList($userid){
		$uids = Table_Friend::getInstance()-> getUserFriendIds($userid);
		$userArr = array();
		if(!empty($uids)){
			$userArr = self::getUserInfoArrByUids($uids);
		}
		return $userArr;
	}
	/**
	 * 根据ID获取用户信息
	 * @param  $uids 用户ID数组
	 * @return $array
	 */
	public function getUserInfoArrByUids(array $uids){
		$rs = Table_Userinfo::getInstance()->getUserInfoArrByUids($uids);
		$userArr = array();
		if($rs){
			foreach ($rs as $v){
				$userArr[$v['user_id']] = $v;
			}
		}
		return $userArr;
	}
	/**
	 * 用户加好友
	 * @param $userid 用户ID
	 * @param $friendId 好友ID
	 * @return boolean
	 */
	public function addFriendData($userid,$friendId){
		$isfriend = Table_Friend::getInstance()->isFriendRelation($userid, $friendId);
		if (!$isfriend){
			//添加好友关系
			$data1 = array('userid'=>$userid,'friendid'=>$friendId,'time'=>date('Y-m-d H:i:s'));
			$rs1 = Table_Friend::getInstance()->insert($data1);
			$data2 = array('userid'=>$friendId,'friendid'=>$userid,'time'=>date('Y-m-d H:i:s'));
			$rs2 = Table_Friend::getInstance()->insert($data1);
			if($rs1&&$rs2){
				//修改申请消息
				Table_Message::getInstance()->updateRegMsg($userid,$friendId,2,1);
				Table_Message::getInstance()->updateRegMsg($friendId,$userid,2,1);
				$rs = Table_Message::getInstance()->addMessage($userid,$friendId,2,'','',3);
				return true;
			}
		}
		return false;
	}
	/**
	 * 判断用户关系
	 * @param $userid 用户ID
	 * @param $friendId 好友ID
	 * @return  int 1 是好友 2 收到加好友邀请 
	 */
	public function isFriendRelation($userid,$friendId){
		$isfriend = Table_Friend::getInstance()->isFriendRelation($userid, $friendId);
		$relation = 0;
		if($isfriend){
		$relation =1;
		}else{
		$req_msg = Table_Message::getInstance()->getReqMsg($friendId, $userid, 2);
		if($req_msg)$relarion = 2;
		}
		return $relation;
	}
	/**
	 * 获取用户信息
	 * @param  $userid 用户ID
	 * return array
	 */
	public function getUserInfoById($userid){
		$user_info = Table_Userinfo::getInstance()->find($userid);
		
		return $user_info;
	}
	/**
	 * 上传用户图像
	 */
	public function addUserPic($userid, $file) {
		$path = Core_ApiConfig::get ( 'attachment_dir' ) . 'userphoto/' . Lib_Util::getFacePath ( $userid );
		if (! file_exists ( $path )) {
			if (! Lib_Util::make_dir ( $path )) {
				throw new Exception ( "directory readonly" );
			}
		}
		$rs = copy ( $file, $path . $userid . '_o.jpg' );
		$img = Core_ApiConfig::get ( 'attachment_domain' ) . $userid . '_o.jpg';
		if (file_exists ( $path . $userid . '_o.jpg' )) {
			$this->creatThumbPi ( $path . $userid . '_o.jpg', $path, $userid );
		}
		return $rs ? $img : $rs;
	}
	/**
	 * 生成缩率图
	 * @param unknown_type $file
	 * @param unknown_type $path
	 * @param unknown_type $userid
	 * @return resizeimage
	 */
	function creatThumbPi($file, $path, $userid) {
		$picArr = Lib_Util::userPicArr ( $file, $path, $userid );
		if ($picArr ['arr']) {
			foreach ( $picArr ['arr'] as $val ) {
				$t = new resizeimage ( $file, $val ['w'], $val ['h'], $val ['cut'], $path . $val ['name'] . '.jpg' );
			}
		}
		return $t;
	}
	/**
	 * ription 获取用户公用API的TOKEN
	 */
	public function getUserToken($uid) {
		$rs = Dao_Usertoken::getInstance ()->find ( $uid );
		if (! empty ( $rs )) {
			if ($rs ['expired'] < time ()) {
				return false;
			}
		}
		return $rs;
	}
	public function updateSinaToken($uid, $access_token, $expire) {
		$usertoken = Dao_Usertoken::getInstance ()->find ( $uid );
		$token = new Model_Usertoken ();
		$token->uid = $uid;
		$token->access_token = $access_token;
		$token->expired = time () + $expire;
		$token->gentime = time ();
		$token = array (
				'uid' 
		);
		if (empty ( $usertoken )) {
			$dt = Dao_Usertoken::getInstance ()->insert ( $token );
			return true;
		} else {
			return Dao_Usertoken::getInstance ()->update ( $token );
		}
	}
}
