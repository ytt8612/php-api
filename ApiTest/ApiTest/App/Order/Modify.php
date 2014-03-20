<?php
/**
 * 修改订单信息接口 
 * @author anneyan
 */
class Order_Modify  extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		//修改订单

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