<?php
class Table_Bookinfo extends Core_Db_ApiTable{
	
	public $db;

	protected $_tablename = 'book_info';

	protected $_pk = 'id';
	
	/**
	 * 数据库字段名
	 *
	 * @var type array
	 */
	protected $_fields = array ('id','isbn10','isbn13','title','summary','author','author_intro','image','pages','price','author_intro','publisher','pubdate','time');
	/**
	 *
	 * @return Table_Usertoken
	 */
	public static function getInstance(){
		return parent::getInstance();
	}
	/**
	 * 添加图书
	 */
	public function addBook($data){
		foreach($data as $key=>$val){
			if(!empty($this->_fields)&&!in_array($key,$this->_fields)) unset($data[$key]);
		}
		return parent::insert($data);
	}
	/**
	 * 根据二维码查询书籍信息
	 * @param $isbn 二维码
	 */
	public function getBookByIsbn($isbn){
		$len = strlen($isbn);
		if($len==10){
		 $rs = $this->getQuery()->where('isbn10 = ?', $isbn)->order('id DESC')->fetch();
		}else{
			$rs = $this->getQuery()->where('isbn13 = ?', $isbn)->order('id DESC')->fetch();
		}
		return $rs;
	}
	
	public function getBooksByIds($ids=array(),$page,$num){
		$offset = $page ? ($page-1)*$page : 0;
		$id_str = implode(',', $ids);
		$sql = "select p.pub_id,p.book_id,p.user_id,p.username,p.lent_way,p.loan_period,p.deposit, p.address ,p.public_time,p.loan_status, b.title,b.author,b.image,b.price,b.publisher ,b.summary from user_books as p left join book_info as b on p.book_id = b.id where p.book_id in ('$id_str') and p.book_status =1 order by p.pub_id desc limit $num offset $offset ";
		$rs= $this->query($sql);
		return $rs;
	}
	
	public function getAllBookByPage($page,$num){
		  $offset = $page ? ($page-1)*$page : 0;
			$sql = "select p.pub_id,p.book_id,p.user_id,p.username,p.lent_way,p.loan_period,p.deposit ,p.address ,p.public_time , p.loan_status,b.title,b.author,b.image,b.price,b.publisher ,b.summary from user_books as p left join book_info as b on p.book_id = b.id where p.book_status =1 order by p.pub_id desc limit $num offset $offset ";
			$rs= $this->query($sql);
			return $rs;
	}
	
}