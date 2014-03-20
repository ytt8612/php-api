<?php
class Table_Friend extends Core_Db_ApiTable{

	protected $_tablename = 'friend';

	protected $_pk = 'id';
	/**
	 * @return Table_Friend
	 */
	public static function getInstance() {
		return parent::getInstance ();
	}
	/**
	 * 查找用户的好友ID
	 * @param  $userid 用户ID
	 * @return array
	 */
	public function  getUserFriendIds($userid){
		$rs =  $this->getQuery()->where('userid = ?' ,$userid)->select(' distinct( friendid) ')->order('id desc')->fetchAll();
		$ids = array();
		if($rs){
			foreach ($rs as $v){
				$ids[]=$v['friendid'];
			}
		}
		return $ids;
	}
	/**
	 * 判断用户是否是好友关系
	 * @param $userid 用户ID
	 * @param $friendId 好友Id
	 * @return boolean
	 */
	public function isFriendRelation($userid,$friendId){
		$rs1 =  $this->getQuery()->where('userid = ?', $userid)->where(' friendid = ?',$friendId)->fetch();
		$rs2  = $this->getQuery()->where('userid = ?',$friendId)->where(' friendid = ?', $userid)->fetch();
		if($rs1 && $rs2){
			return true;
		}
		return false;
	}
}