<?php
class Table_Usercontact extends Core_Db_ApiTable{

	protected $_tablename = 'user_contacts';

	protected $_pk = 'id';
	/**
	 * @return Table_Usercontact
	 */
	public static function getInstance() {
		return parent::getInstance ();
	}
	/**
	 * 查询用户私信对话
	 * @param  $userid 查询ID
	 * @param  $fromUserid 消息来源
	 * @return array
	 */
 public function getUserContactByUid($userid,$fromUserid){
 	return $this->getQuery()->where('user_id = ?', $userid)->where('contact_id = ?', $fromUserid)->fetch();
 }
 /**
  * 未读私信清0
  * @param  $userid 查询ID
	 * @param  $fromUserid 消息来源
  */
 public function clearUnreadContact($userid,$fromUserid){
 	  $rs = self::getUserContactByUid($userid,$fromUserid);
 	  if($rs){
 	  	$data = array(
 	  			 'id'=>$rs['id'],
 	  			 'unread_count'=>0
 	  			);
 	  	$this->update($data);
 	  }
 	  return true;
 }
 	/**
	 * 私信联系人列表
	 * @param unknown_type $userid
	 * @param unknown_type $num
	 * @param unknown_type $page
	 * @return multitype:
	 */
	function getMsgContact($userid, $num, $page) {
		$offset = $num*($page-1);
		$limit = $num;
		$rs = $this->getQuery()->where('user_id = ?', $userid)->limit($limit,$offset)->order(' last_time DESC')->fetchAll();
		return $rs;
	}
}