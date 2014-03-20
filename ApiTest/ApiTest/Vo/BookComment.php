<?php
class Vo_BookComment extends Core_ApiVo{

	public static function process($data) {
		foreach($data as $val){
			$list[]=array(
					'comment_id'=>$val['comment_id'],
					'pub_id'=>$val['pub_id'],
					'user_id'=>$val['userid'],
					'username'=>$val['username'],
					'user_pic'=> Lib_Util::getUserPic(1,$val['userid']),
					'content'=>$val['content'],
					'points'=>$val['points'],
					'time'=>strtotime($val['time'])

			);
		}
		return $list;
	}
}