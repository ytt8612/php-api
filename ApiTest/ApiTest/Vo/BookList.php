<?php
class Vo_BookList extends Core_ApiVo{

	public static function process($data) {
		$lent_ways = array('1'=>'当面借阅','2'=>'押金借阅');
		$loan_status = array('0'=>'不可借','1'=>'可借阅','2'=>'已借出');
		foreach($data as $val){
			$s_image = Lib_Util::get_book_photo($val['book_id']);
			$list[]=array(
					 'pub_id'=>$val['pub_id'],
					 'user_id'=>$val['user_id'],
					 'username'=>$val['username'],
					 'title'=>$val['title'],
					 'author'=>$val['author'],
					 'image'=>$s_image ? $s_image :$val['image'],
					 'publisher'=>$val['publisher'],
					 'price'=>$val['price'],
					 'lent_way'=>isset($lent_ways[$val['lent_way']]) ? $lent_ways[$val['lent_way']] : $lent_ways[1],
					 'deposit'=>$val['deposit'],
					 'loan_period'=>$val['loan_period'],
					 'loan_status'=>isset($loan_status[$val['loan_status']]) ? $loan_status[$val['loan_status']] : $loan_status[0],
					 'public_time'=>strtotime($val['public_time'])
					 
					);
		}
		return $list;
	}
}