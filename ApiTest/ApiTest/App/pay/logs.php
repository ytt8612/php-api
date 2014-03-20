<?php
/**
 * 乐享豆此操作日志列表
 * @author 严廷廷
 */
class App_Pay_Logs extends Core_ApiApplication
{

	public function run ()
	{
		$info = Service_Security::getInstance()->getInfoFromSessionId(Core_ApiRequest::getInstance()->getSessID());
		if (! $info) {
			throw new Exception_Yiban(Lang_Zh_Common::SESSID_ERROR, 106);
		}
		$userid = $this->params['userid'] ? $this->params['userid'] : $info['userid'];
		$rs = Service_Pay::getInstance()->getCoinLogList($userid,$this->params['page'],$this->params['num']);
		if($rs['arr']){
			$rs['arr']=Vo_PayLog::process($rs['arr']);
		}
		return $rs;
	}
	
	public function paramRules ()
	{
		return array(
				'userid' => array (
						'default'=>0
				),
				'page' => array (
						'default'=>1
				),
				'num' => array (
						'default'=>20
				)
		);
	}
	
}