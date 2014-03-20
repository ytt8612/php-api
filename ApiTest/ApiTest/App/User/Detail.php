<?php
/**
 * App_User_Detail 用户详情接口
 * @author 严廷廷 
 * 
 */
class App_User_Detail extends Core_ApiApplication {
	public function run(){
		$info = Service_Security::getInstance()->getInfoFromSessionId(Core_ApiRequest::getInstance()->getSessID());
		if (! $info) {
			throw new Exception_Yiban(Lang_Zh_Common::SESSID_ERROR, 106);
		}
		$rs = Service_User::getInstance()->getUserInfoById($info['userid']);
		$user =  Vo_User::process ( $rs);
		return array('user'=>$user);
	}
	public function paramRules ()
	{
		return array(
				'user_id' => array(
						'validators' => array (
								new Core_Validator_ApiNotEmpty ()
						)
				)
		);
	}
}