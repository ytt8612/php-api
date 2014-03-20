<?php
/**
 * 用户私信列表接口 
 * @author 严廷廷
 */
class App_Message_Contacts extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
		}
		$userid = $this->params['userid'] ? $this->params['userid'] : $info['userid'];
    $contact = Service_Message::getInstance()-> getMsgContact($userid, $this->params['num'], $this->params['page']);
    	if (isset($contact['arr']) && ! empty($contact['arr'])) {
    		foreach ($contact['arr'] as $con) {
    			$uids[] = $con['contact_id'];
    		}
    	$userArr = Service_User::getInstance()->getUserInfoArrByUids($uids);
    	$contact['arr'] = Vo_MessageContact::process ( $contact['arr'],$userArr);
    	return $contact;
    }
	}
	public function paramRules() {
		return array (
				'userid' => array (
						'default' => '0'
				),
				'num' => array (
						'default' => '10'
				),
				'page' => array (
						'default' => '1'
				)
		);
	}
}