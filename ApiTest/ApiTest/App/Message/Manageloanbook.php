<?php
/**
 * 图书借阅申请处理接口 Message_Manageloanbook
 * @author  anneyan
 */
class Message_Manageloanbook  extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		//借书申请处理 1 同意 2 拒绝 3 付款 4 收到书 5还书 6结束
		$type = array(0,1,2,3,4,5,6,7);
		$op = $this->param['type']; // 1 同意 2 拒绝
		
		$ret = Service_Message::getInstance()->manageLoanBookMsg($this->params['mid'],$info['userid'],$op);
		if($ret['code']==100){
			return array('result'=>1);
		}else{
			 throw new Exception_Yiban($ret['message'], 101);
		}
	}
	public function paramRules() {
		return array(
				'msg_id' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				),
				'type' => array(
						'default' => '1'
				),
	
		);
	}
}