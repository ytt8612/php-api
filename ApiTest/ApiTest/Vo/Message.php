<?php
class Vo_Message extends Core_ApiVo{

	public static function process($data,$userArr=array()) {
		    $user = isset($userArr[$data['from_userid']]) ? Vo_User::process($userArr[$data['from_userid']]) : array();
		    
		    $msg = array(
		    		 'msg_id'=>$data['msg_id'],
		    		 'kind'=>$data['msg_kind'],
		    		 'content'=>$data['msg_content'],
		    		 'time'=>strtotime($data['create_time']),
		    		 'result'=>$data['result'] ? 1 : 0,
		    		 'status'=>$data['status'],
		    		  'user' => $user,
		    		);
		 return $msg;

	}

}