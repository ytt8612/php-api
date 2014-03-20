<?php
/**
 * 确认订单接口
 * @author anneyan
 */
class Order_Confirm  extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		//借书申请处理 1 同意 2 拒绝 
		$op = $this->param['type']; // 1 同意 2 拒绝
		$ret = Service_Order::getInstance()->confirmOrder($this->params['order_id'],$info['userid'],$op);
		if($ret['code']==100){
			return array('result'=>1);
		}else{
			throw new Exception_Yiban($ret['message'], 101);
		}
	}
	public function paramRules() {
		return array(
				'order_id' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				),
				'type' => array(
						'default' => '1'
				)

		);
	}
}