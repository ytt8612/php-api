<?php
class Table_UserOrder extends Core_Db_ApiTable{

	protected $_tablename = 'user_order';

	protected $_pk = 'order_id';

	/**
	 * 数据库字段名
	 *
	 * @var type array
	 */
	protected $_fields = array ();
	/**
	 *
	 * @return Table_UserOrder
	*/
	public static function getInstance(){
		return parent::getInstance();
	}
}