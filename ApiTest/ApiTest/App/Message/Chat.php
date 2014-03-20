<?php
/**
 * 私信对话列表接口
 * @author 严廷廷
 */
class App_Message_Chat extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$rs = Service_Message::getInstance()->getMsgChat($this->params['userid'], $info['userid'], $this->params['num'],$this->params['page'], $this->params['last_id']);
		if($rs['arr']){
			$rs['arr'] = Vo_MessageChat::process ( $rs['arr']);
		}
		return $rs;
	}
	public function paramRules() {
		return array (
				'userid' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty () 
						) 
				),
				'num' => array (
						'default' => '10' 
				),
				'page' => array (
						'default' => '1' 
				),
				'last_id' => array (
						'default' => '0' 
				) 
		);
	}
}