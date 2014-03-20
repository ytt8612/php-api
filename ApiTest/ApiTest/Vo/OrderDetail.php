<?php
class Vo_OrderDetail extends Core_ApiVo{

	public static function process($data) {
		    $var = unserialize($data['var1']);
		    $s_image = isset($var['book_id']) ? Lib_Util::get_book_photo($var['book_id']) : '';
		    $var['book_image']=$s_image;
		    $order = array(
		    		 'order_id'=>$data['order_id'],
		    		 'order_code'=>$data['order_code'],
		    		 'from_userid'=>$data['from_userid'],
		    		 'to_userid'=>$data['to_userid'],
		    		 'address'=>$data['address'],
		    		 'coin'=>$data['coin'],
		    		 'loan_time'=>isset($data['loan_time']) ? $data['loan_time'] : '',
		    		 'time'=>strtotime($data['create_time']),
		    		 'order_status'=>$data['order_status'] ? $data['order_status'] : 0,
		    		'book'=>$var,
		    		);
		 return $order;

	}

}