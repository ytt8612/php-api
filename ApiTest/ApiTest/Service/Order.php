<?php
/**
 * 订单处理类
 * @author anneyan
 */
class Service_Order extends Core_ApiService {
	/**
	 * @return Service_Book
	 */
	public static function getInstance() {
		return parent::getInstance();
	}
	/**
	 * 获取订单详情
	 * @param $order_id 订单ID
	 * @return array
	 */
	public function getOrderById($order_id){
		return Table_UserOrder::getInstance()->find($order_id);
	}
	/**
	 * 确认订单操作
	 * @param $order_id 订单
	 * @param $userid 用户ID
	 * @param $op 处理类型 1 同意 2 拒绝
	 * @return array
	 */
	public function confirmOrder($order_id,$userid,$op){
		$order = Table_UserOrder::getInstance()->find($order_id);
		if(empty($order)){
			return array('code'=>101,'message'=>'订单不存在！');
		}elseif($order['to_userid']!=$userid){
			return array('code'=>101,'message'=>'用户无权限操作！');
		}elseif($order['order_status']!=1){
			return array('code'=>101,'message'=>'订单状态不正确！');
		}
		if($op==1){
			//检查图书是否可借
			$pub_id = $order['pub_id'];
			$book = Table_UserBook::getInstance()->find($pub_id);
			if(empty($book)){
				return array('code'=>101,'message'=>'图书不存在或者已下架！');
			}elseif($book['book_status']!=1){
				return array('code'=>101,'message'=>'图书状态不可借！');
			}
			//修改订单状态
			$data = array(
					'order_id'=>$order_id,
					'order_status'=>3,
					'last_time'=>date('Y-m-d H:i:s')
			);
			$rs =Table_UserOrder::getInstance()->update($data);
		
		}else{
			//修改申请消息
			$data = array(
					'order_id'=>$order_id,
					'order_status'=>2,
					'last_time'=>date('Y-m-d H:i:s')
			);
			$rs =Table_UserOrder::getInstance()->update($data);
		}
		return array('code'=>100,'result'=>$rs);
	}
}