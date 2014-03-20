<?php
/**
 * 处理加好友邀请
 * @author 严廷廷
 */

class App_Message_Managefriendreq extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$op = $this->param['type']; // 1 同意 2 拒绝
		$ret = Service_Message::getInstance()->manageFriendReq($this->params['mid'],$info['userid'],$op);
		if($ret['code']==100){
			return array('result'=>1);
		}else{
			 throw new Exception_Yiban($ret['message'], 101);
		}
	}
	public function paramRules() {
		return array(
				'mid' => array(
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