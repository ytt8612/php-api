<?php
class Table_Tags extends Core_Db_ApiTable{

	protected $_tablename = 'en_tag';

	protected $_pk = 'tag_id';
	/**
	 *
	 * @return Table_Tags
	 */
	public static function getInstance(){
		return parent::getInstance();
	}
	/**
	 * 检索标签
	 * @param $tag
	 */
	public function getTag($tag){
		return $this->getQuery()->where('tag = ?', $tag)->fetch();
	}
}
