<?php
class Vo_Book extends Core_ApiVo{

	public static function process($data) {
		$lent_ways = array('1'=>'当面借阅','2'=>'押金借阅');
		$loan_status = array('0'=>'不可借','1'=>'可借阅','2'=>'已借出');
		$s_image = Lib_Util::get_book_photo($data['book_id']);
			$book=array(
					 'pub_id'=>$data['pub_id'],
					 'user_id'=>$data['user_id'],
					 'username'=>$data['username'],
					 'title'=>$data['title'],
					 'author'=>$data['author'],
					 'summary'=>$data['summary'],
					 'author_intro'=>$data['author_intro'],
					 'image'=>$s_image ? $s_image :$data['image'],
					 'publisher'=>$data['publisher'],
					 'pubdate'=>$data['pubdate'],
					 'price'=>$data['price'],
					 'lent_way'=>isset($lent_ways[$data['lent_way']]) ? $lent_ways[$data['lent_way']] : $lent_ways[1],
					 'loan_status'=>isset($loan_status[$data['loan_status']]) ? $loan_status[$data['loan_status']] : $loan_status[0],
					 'deposit'=>$data['deposit'].'乐享豆',
					 'loan_period'=>$data['loan_period'].'天',
					 'time'=>strtotime($data['time'])
					 
					);

		return $book;
	}
}