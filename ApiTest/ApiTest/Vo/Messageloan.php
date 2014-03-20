<?php
class Vo_Messageloan extends Core_ApiVo{

	public static function process($data) {
		    $var = unserialize($data['var1']);
		    $s_image = isset($var['book_id']) ? Lib_Util::get_book_photo($var['book_id']) : '';
		    $msg = array(
		    		 'msg_id'=>$data['msg_id'],
		    		 'msg_content'=>$data['msg_content'],
		    		 'userid'=>$data['from_userid'],
		    		 'username'=>$var['username'],
		    		 'pub_id'=>$var['pub_id'],
		    		 'book_name'=>$var['bood_name'],
		    		 'book_author'=>isset($var['book_author']) ? $var['book_author'] : '',
		    		 'book_image'=>$s_image,
		    		 'loan_time'=>isset($var['loan_time']) ? $var['loan_time'] : '',
		    		 'time'=>strtotime($data['create_time']),
		    		 'result'=>$data['msg_result'] ? $data['msg_result'] : 0,
		    		);
		 return $msg;

	}

}