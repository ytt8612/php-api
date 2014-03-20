<?php
class Table_Userinfo extends Core_Db_ApiTable{

	protected $_tablename = 'user_info';
	
	protected $_pk = 'user_id';
	
	public static function getInstance() {
		return parent::getInstance ();
	}
	
	/**
	 * 根据邮箱查询用户
	 * @param $email 邮箱
	 * @return array
	 */
	public  function getUserInfoByEmail($email){
		$rs =$this->getQuery()->where('email = ?', $email)->fetch();
		return $rs;
	}
	/**
	 * 根据电话查询用户
	 * @param $phone_num
	 * @return array
	 */
	public  function getUserInfoByPhone($phone_num){
		return $this->getQuery()->where('phone_num = ?', $phone_num)->fetch();
	}
		/**
	 * 根据ID获取用户信息
	 * @param  $uids 用户ID数组
	 * @return $array
	 */
	public function getUserInfoArrByUids(array $uids){
		$rs = $this->getQuery()->whereIn('user_id',$uids)->fetchAll();
		return $rs;
	}
}