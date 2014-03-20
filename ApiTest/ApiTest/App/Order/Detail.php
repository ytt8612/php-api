<?php
/**
 * 订单详情接口 Order_Detail
 * @author anneyan
 */
class App_Order_Detail extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		//获取订单详情
		$order = Service_Order::getInstance()->getOrderById($this->params['order_id']);
		if(empty($order)){
			throw new Exception_Yiban ( Lang_Zh_Common::ORDER_EMPTY, 101 );
		}
		$order = Vo_OrderDetail::process($order);
		//获取私信对话列表
		$rs = Service_Message::getInstance()->getLoanMsgChat($order['to_userid'], $order['from_userid'],2,$order['order_id']);
		$charts = Vo_MessageChat::process ( $rs);
		return array('order'=>$order,'charts'=>$charts);
	}
	public function paramRules() {
		return array(
				'order_id' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				)

		);
	}
}