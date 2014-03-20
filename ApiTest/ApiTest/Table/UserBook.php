<?php
/**
 * 用户上图书表
 * @author 严廷廷
 */
class Table_UserBook extends Core_Db_ApiTable{

	protected $_tablename = 'user_books';

	protected $_pk = 'pub_id';
	
	public static function getInstance() {
		return parent::getInstance ();
	}
	/**
	 * 根据图书ID检索用户发布的信息
	 * @param  $book_id 图书ID
	 * @param  $userid 用户ID
	 * @return array
	 */
	public function getUserPubByBookId($userid,$book_id){
		$rs =  $this->getQuery()->where('user_id = ?', $userid)->where(' book_id = ?',$book_id)->fetchAll();
		return $rs;
	}
}