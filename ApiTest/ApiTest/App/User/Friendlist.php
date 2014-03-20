<?php
/**
 * 获取好友列表接口
 * @author 严廷廷
 */
class App_User_Friendlist extends Core_ApiApplication {
	public function run(){
		$info = Service_Security::getInstance()->getInfoFromSessionId(Core_ApiRequest::getInstance()->getSessID());
		if (! $info) {
			throw new Exception_Yiban(Lang_Zh_Common::SESSID_ERROR, 106);
		}
		$userid = $this->params['userid'] ? $this->params['userid'] : $info['userid'];
		$rs = Service_User::getInstance()->getAllFriendList($info['userid']);
		//$user =  Vo_User::process ( $rs);
		return $rs;
	}
	public function paramRules ()
	{
		return array(
				'userid' => array(
						 'default' => ''
				)
		);
	}
}