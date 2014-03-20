<?php
class Table_UserAuthcode extends Core_Db_ApiTable{

	protected $_tablename = 'user';

	protected $_pk = 'user_id';
	/**
	 * 用户手机验证码表
	 * @return Table_UserAuthcode
	 */
	public static function getInstance() {
		return parent::getInstance ();
	}
 /**
  * 根据手机号码获取有效验证码
  * @param $phone_num 电话号码
  */
	public function getAuthcodeByPhone($phone){
		$rs = $this->getQuery()->where('phone_num = ?', $phone)->where('status = ?', 0)->limit(1)->order(' id DESC')->fetchRow();
		return $rs;
	}
}