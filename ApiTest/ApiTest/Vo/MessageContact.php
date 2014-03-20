<?php
class Vo_MessageContact extends Core_ApiVo{

	public static function process($data,$userArr=array()) {
    $list = array();
    if(count($data)>0){
    	foreach ($data as $v){
    		$user = isset($userArr[$v['contact_id']]) ? Vo_User::process($userArr[$v['contact_id']]) : array();
		    $list[] = array(
		    		 'id'=>$v['id'],
		    		 'contact_id'=>$v['contact_id'],
		    		 'content'=>$v['content'],
		    		 'time'=>strtotime($v['last_time']),
		    		 'unread_count'=>$v['unread_count'],
		    		  'user' => $user,
		    		);
    	}
    }

		return $list;

	}

}