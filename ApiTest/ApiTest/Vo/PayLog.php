<?php

class Vo_PayLog extends Core_ApiVo{

	public static function process($data) {
		$list = array();
		if(count($data)>0){
			foreach ($data as $v){
				if($v['code']=='roll_in'){
					if($v['from_userid']){
						$v['desc'] ='好友赠送';
					}else{
					  $v['desc'] ='系统赠送';
					}
				}elseif($v['code']=='roll_out'){
					$v['desc'] ='转增好友';
				}
				$list[] = array(
						'id'=>$v['id'],
						'code' => $v['code'],
						'content'=>$v['desc'],
						'coin'=>$v['coin'],
						'time'=>strtotime($v['dateline'])
				);
			}
		}

		return $list;

	}

}
