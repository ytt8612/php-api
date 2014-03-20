<?php
/**
 * 圈子逻辑处理类
 * @author 严廷廷 20140124
 */
class Service_Circle extends Core_ApiService {

	/**
	 * @return Service_Circle
	 */
	public static function getInstance() {
		return parent::getInstance();
	}
	/**
	 * 查询圈子列表
	 * @param $page 
	 * @param $num 
	 */
	public function getCircleList($page,$num){
		$page = $page>=1 ? $page : 1;
		$rs['arr'] =  Table_Circle::getInstance()->getCricleList($page,$num+1);
		$rs['havenext'] = 0;
		if (count($rs['arr']) >= $num ) {
			array_pop($rs['arr']);
			$rs['havenext'] = 1;
		}
		return $rs;
	}
	/**
	 * 查询用户加入的圈子
	 * @param  $userid 用户ID
	 * @return array
	 */
	function getJoinCircleByUid($user_id){
		$rs = Table_Circlemember::getInstance()->getJoinCircleByUid($user_id);
		$list = array();
		if(!empty($rs)){
			foreach($rs as $k=>$v){
				$list[$v['circle_id']] =$v;
			}
		}
		return $list;
	}
	/**
	 * 加入圈子
	 * @param $userid 用户ID
	 * @param $username 用户名
	 *  @param $circle_id 圈子名Id
	 * @param $circle_name 圈子名
	 */
	function joinCircle($userid,$username,$circle_id,$circle_name){
		//创建者加入圈子
		$data = array('circle_id'=>$circle_id,'circle_name'=>$circle_name,'user_id'=>$userid,'username'=>$username,'time'=>date('Y-m-d H:i:s'));
		return Table_Circlemember::getInstance()->insert($data);
	}
	/**
	 * 创建圈子
	 * @param $userid 用户ID
	 * @param $username 用户名
	 * @param $circle_name 圈子名
	 * @param $kind 圈子类型
	 * @param $address 地理位置
	 * @param $lat 经度坐标
	 * @param $lng 纬度坐标
	 * @return  int|boolean
	 */
	function createCircle($userid,$username,$circle_name,$kind,$address,$lat,$lng){
		$circle = array(
				 'user_id'=>$userid,
				 'moderator_id'=>$userid,
				 'circle_name'=>$circle_name,
				 'kind'=>$kind,
				 'address'=>$address,
				 'lat'=>$lat,
				 'lng'=>$lng,
				 'time'=>date('Y-m-d H:i:s')
				);
		$circle_id = Table_Circle::getInstance()->insert($circle);
		if($circle_id){
			//创建者加入圈子
			$data = array('circle_id'=>$circle_id,'circle_name'=>$circle_name,'user_id'=>$userid,'username'=>$username,'time'=>date('Y-m-d H:i:s'));
			Table_Circlemember::getInstance()->insert($data);
		}
		return $circle_id;
	}
	
	/**
	 * 根据条件查询圈子
	 * @param  $where
	 * @return array
	 */
	function  getCricleByName($cricle_name){
		return Table_Circle::getInstance()->getCricleByName($cricle_name);
	}
	/**
	 * 根据条件查询圈子
	 * @param  $where
	 * @return array
	 */
	function  getCricleById($cricle_id){
		return Table_Circle::getInstance()->find($cricle_id);
	}
}