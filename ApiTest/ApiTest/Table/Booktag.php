<?php
class Table_Booktag extends Core_Db_ApiTable{

	protected $_tablename = 'book_tag';

	protected $_pk = 'book_id';

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
	public function getBookIdsByTagId($tag_id){
		$rs =  $this->getQuery()->where('tag_id = ?' ,$tag_id)->select(' distinct( book_id) ')->order('id desc')->fetchAll();
		$ids = array();
		if($rs){
			foreach ($rs as $v){
				$ids[]=$v['book_id'];
			}
		}
		return $ids;
	}
}