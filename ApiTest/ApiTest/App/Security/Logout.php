<?php
/**
 * 登出接口
 * @author anneyan
 */
class App_Security_Logout extends Core_ApiApplication {
	public function run() {
		$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
		if (! $info) {
			//throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
			
			return array('result'=>1);
		}

		Service_Security::getInstance()->removeSessionId($info['userid']);
	//	Service_Security::getInstance()->removeUserToken($info['userid']);
		return array('result'=>1);
	
	}
	public function paramRules() {
		return array();
	}
}