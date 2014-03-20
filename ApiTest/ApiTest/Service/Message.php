<?php
/**
 * 消息处理类
 * @author 严廷廷
 *
 */
class Service_Message extends Core_ApiService {
 
	private $kind_c = array(1,2,3);//群组消息的分类  1 借书预约 2 申请加好友 3 同意加好友
	/**
	 * @return Service_Message
	 */
	public static function getInstance() {
		return parent::getInstance();
	}

	/**
	 * 处理加好友申请
	 * @param $mid 消息id
	 * @param $userid 用户ID
	 * @param $op 处理类型 1 同意 2 拒绝
	 * @return array
	 */
	public function manageLoanBookMsg($mid,$userid,$op){
		if($op==1){
			$msg = Table_Message::getInstance()->find($mid);
			if(empty($msg)){
				return array('code'=>101,'message'=>'消息不存在！');
			}elseif($msg['to_userid']!=$userid){
				return array('code'=>101,'message'=>'用户无权限操作！');
			}
			//检查图书是否可借
			$var = unserialize($msg['var1']);
			$pub_id = $var['pub_id'];
			$book = Table_UserBook::getInstance()->find($pub_id);
			if(empty($book)){
				return array('code'=>101,'message'=>'图书不存在或者已下架！');
			}elseif($book['book_status']!=1){
				return array('code'=>101,'message'=>'图书状态不可借！');
			}
			//同意借书申请 生成订单
			 
			//修改申请消息
			$data = array(
					'msg_id'=>$mid,
					'result'=>1
			);
			$rs =Table_Message::getInstance()->update($data);
				
		}else{
			//修改申请消息
			$data = array(
					'msg_id'=>$mid,
					'result'=>2
			);
			$rs =Table_Message::getInstance()->update($data);
		}
		return array('code'=>100,'result'=>$rs);
	}
	
	/**
	 * 私信联系人列表
	 * @param unknown_type $userid
	 * @param unknown_type $num
	 * @param unknown_type $page
	 * @return multitype:
	 */
	function getMsgContact($userid, $num, $page) {
		$page = $page>=1 ? $page : 1;
		$rs['arr'] = Table_Usercontact::getInstance()->getMsgContact($userid, $num, $page);
		$rs['havenext'] = 0;
		if (count($rs['arr']) >= $num ) {
			array_pop($rs['arr']);
			$rs['havenext'] = 1;
		}

		return $rs;
	}
	/**
	 * 获取借书私信对话列表
	 * @param  $to_userid 收信人ID
	 * @param  $from_userid 发件人ID
	 * @param  $kind  消息类型
	 * @param  $var1 扩展字段 消息ID
	 * @return $list
	 */
	function getLoanMsgChat($to_userid, $from_userid,$msg_kind,$var1=''){
		$rs = Table_Msguser::getInstance()->getLoanMsgChat($to_userid, $from_userid,$msg_kind,$var1);
		return $rs;
	}
	/**
	 * 私信对话列表
	 * @param unknown_type $to_userid
	 * @param unknown_type $from_userid
	 * @param unknown_type $num
	 * @param unknown_type $page
	 * @param unknown_type $last_id
	 * @return multitype:number NULL
	 */
	function getMsgChat($to_userid, $from_userid, $num, $page, $last_id=0) {
		$page = $page>=1 ? $page : 1;
		$rs['arr'] = Table_Msguser::getInstance()->getMsgChat($from_userid,$to_userid,$page,$num+1,$last_id);
		$rs['havenext'] = 0;
		if (count($rs['arr']) >= $num ) {
			array_pop($rs['arr']);
			$rs['havenext'] = 1;
		}
		// 未读取的记录数清0
		Table_Usercontact::getInstance()->clearUnreadContact($to_userid, $from_userid);
		return $rs;
	}
	/**
	 * 发私信
	 * @param $fromUserid 发信人ID
	 * @param $to_userid 收信人ID
	 * @param $content 私信内容
	 * @param $kind   1 => 私信对话， 2 => 借书私信,3=>乐享豆交易
	 * @param $var1  扩展字段
	 * @return int
	 */
	public function sendMsg($fromUserid,$to_userid,$content,$kind=1,$var1=''){
		$msg_id = Table_Msguser::getInstance()->sendMsg($fromUserid,$to_userid,$content,$kind,$var1);
		if($msg_id){
			self::addMsgContact($fromUserid,$to_userid,$content);
		}
		return $msg_id;
	}
	/**
	 * 私信联系人列表数据更新
	 * @param unknown $from_userid
	 * @param unknown $to_userid
	 * @param unknown $content
	 * @return multitype:unknown boolean
	 */
	function addMsgContact($from_userid,$to_userid,$content){
		$contacts = array();
		$time = date('Y-m-d H:i:s',time());
		//发送人
		// 联系记录contactID
		$result = Table_Usercontact::getInstance()->getUserContactByUid($from_userid,$to_userid);
		$contacts[] = $result['id'];
		$is_receive = 0;
		//发送人自己只增加消息数
		if($result) {
	
		  $data = array(
		  		'id'=>$result['id'],
		  		'total_count'=>$result['total_count']+1,
		  		'last_time'=>$time,
		  );
		  $contact_id = Table_Usercontact::getInstance()->update($data);
		}else{
			$data = array(
					'user_id'=>$from_userid,
					'contact_id'=>$to_userid,
					'is_receive'=>0,
					'total_count'=>1,
					'unread_count'=>0,
					'content'=>$content,
					'last_time'=>$time
			);
			$contact_id =Table_Usercontact::getInstance()->insert($data);
		}
		//接收人
		//接收人要更新未读数和消息数
		// 联系记录contactID
		$result2 = Table_Usercontact::getInstance()->getUserContactByUid($to_userid,$from_userid);
		$contacts[] = $result2['id'];
		$is_receive = 1 ;
		if($result2) {
			$data = array(
					'id'=>$result2['id'],
					'total_count'=>$result2['total_count']+1,
					'unread_count'=>$result2['unread_count']+1,
					'last_time'=>$time,
			);
			$contact_id = Table_Usercontact::getInstance()->update($data);
		}else{
			$data = array(
					'user_id'=>$to_userid,
					'contact_id'=>$from_userid,
					'is_receive'=>$is_receive,
					'total_count'=>1,
					'unread_count'=>1,
					'content'=>$content,
					'last_time'=>$time
			);
			$contact_id =Table_Usercontact::getInstance()->insert($data);
		}
			
		return $contacts;
	}
 /**
  * 添加好友申请邀请消息
  * @param $fromUserid 申请人Id
  * @param $userid 被申请人用户ID
  * @param $content 申请消息内容
  * @return boolean
  */
	public function addFriendMsg($formUserid,$userid,$content){
		$isFriend = Service_User::getInstance()->isFriendRelation($formUserid,$userid);
		$rs = false;
		if(!$isFriend){
			$rs = Table_Message::getInstance()->addMessage($formUserid,$userid,2,$content,'',2);
		}elseif($isFriend==2){
			$rs = Service_User::getInstance()->addFriendData($formUserid,$userid);
		}
		return $rs;
	}
	/**
	 * 处理加好友申请
	 * @param $mid 消息id
	 * @param $userid 用户ID
	 * @param $op 处理类型 1 同意 2 拒绝
	 * @return array
	 */
	public function manageFriendReq($mid,$userid,$op){
		if($op==1){
		 $msg = Table_Message::getInstance()->find($mid);
		 if(empty($msg)){
			return array('code'=>101,'message'=>'消息不存在！');
		 }
		 if($msg['to_userid']!=$userid){
		 	return array('code'=>101,'message'=>'用户无权限操作！');
		 }
		 $rs = Service_User::getInstance()->addFriendData($msg['from_userid'],$userid);
		 
		}else{
			//修改申请消息
			$data = array(
					'msg_id'=>$mid,
					'result'=>2
					);
			$rs =Table_Message::getInstance()->update($data);
		}
		return array('code'=>100,'result'=>$rs);
	}
}