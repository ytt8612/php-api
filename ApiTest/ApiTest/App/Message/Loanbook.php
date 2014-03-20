<?php
/**
 * 图书申请借阅消息 message_loanbook
 * @author AnneYan
 * 
 */
class App_Message_Loanbook extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
	  //获取借阅消息
		$msg = Table_Message::getInstance()->find($this->params['msg_id']);
		if(empty($msg)){
			throw new Exception_Yiban ( Lang_Zh_Common::MESSAGE_EMPTY, 101 );
		}elseif($msg['msg_kind']!=2){
			throw new Exception_Yiban ( Lang_Zh_Common::MESSAGE_KIND_ERROR, 101 );
		}
		$msg = Vo_Messageloan::process($msg);
	  //获取私信对话列表
	  $rs = Service_Message::getInstance()->getLoanMsgChat($info['userid'], $msg['userid'],2,$msg['msg_id']);
	  $charts = Vo_MessageChat::process ( $rs);
		return array('msg'=>$msg,'charts'=>$charts);
	}
	public function paramRules() {
		return array(
				'msg_id' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				)

		);
	}
}