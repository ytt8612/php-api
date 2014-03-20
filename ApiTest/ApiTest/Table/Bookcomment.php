<?php
class Table_Bookcomment extends Core_Db_ApiTable{

	protected $_tablename = 'book_comments';

	protected $_pk = 'commentid';

	/**
	 * 数据库字段名
	 *
	 * @var type array
	 */
	protected $_fields = array ();
	/**
	 *
	 * @return Table_Bookcomment
	*/
	public static function getInstance(){
		return parent::getInstance();
	}
	/**
	 *获取图书评论列表
	 * @param $pub_id 图书发布ID
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getPubBookCommentList($pub_id,$limit,$offset){
    $rs = $this->getQuery()->where('pub_id = ?', $pub_id)->limit($limit,$offset)->order(' comment_id DESC')->fetchAll();
    return $rs;
	}
}