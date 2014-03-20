<?php

class Vo_MessageChat extends Core_ApiVo{

	public static function process($data) {
		$list = array();
		if(count($data)>0){
			foreach ($data as $v){
				$list[] = array(
						'id'=>$v['id'],
						'user_id'=>$v['userid'],
						'user_pic' => Lib_Util::getUserPic(1,$v['userid']),
						'content'=>$v['content'],
						'time'=>strtotime($v['time'])
				);
			}
		}

		return $list;

	}

}
