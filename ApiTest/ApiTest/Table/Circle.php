<?php
class Table_Circle extends Core_Db_ApiTable {
	protected $_tablename = 'circle';
	protected $_pk = 'circle_id';
	
	/**
	 * 数据库字段名
	 *
	 * @var type array
	 */
	protected $_fields = array (
			'cricle_id',
			'cricle_name',
			'user_id',
			'moderator_id',
			'kind',
			'lat',
			'lng',
			'time',
			'status',
			'sys' 
	);
	/**
	 *
	 * @return Table_Cricle
	 */
	public static function getInstance() {
		return parent::getInstance ();
	}
	/**
	 * 根据条件查询圈子
	 * 
	 * @param
	 *        	$where
	 * @return array
	 */
	function getCricleByName($cricle_name) {
		return $this->getQuery ()->where ( 'circle_name = ?', $cricle_name )->order ( 'circle_id DESC' )->fetchAll ();
	}
	/**
	 * 获取圈子列表
	 * @param unknown_type $num        	
	 * @param unknown_type $page        	
	 * @return multitype:
	 */
	function getCricleList($page,$num) {
		$offset = $num * ($page - 1);
		$limit = $num;
		$rs = $this->getQuery ()->limit ( $limit, $offset )->order ( ' circle_id DESC' )->fetchAll ();
		return $rs;
	}
}
