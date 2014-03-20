<?php
class Table_User extends Core_Db_ApiTable{

	protected $_tablename = 'user';
	
	protected $_pk = 'user_id';
	/**
	 * @return Service_Album
	 */
	public static function getInstance() {
		return parent::getInstance ();
	}
	
	/**
	 * 根据用户名查询用户
	 * @param $username 用户名
	 * @return array
	 */
	public  function getUserByName($username){
		 $rs = $this->getQuery()->where('username = ?', $username)->fetch();
		 return $rs;
	}
}