<?php
class Table_Circlebook extends Core_Db_ApiTable{

	protected $_tablename = 'circle_book';

	protected $_pk = 'circle_id';

	/**
	 * 数据库字段名
	 *
	 * @var type array
	 */
	protected $_fields = array ();
	/**
	 *
	 * @return Table_Booktag
	*/
	public static function getInstance(){
		return parent::getInstance();
	}
}