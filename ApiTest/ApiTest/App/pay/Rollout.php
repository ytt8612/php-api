<?php
/**
 * 乐享豆转出接口
 * @author 严廷廷
 */
class App_Pay_Rollout extends Core_ApiApplication
{

	public function run ()
	{
		$info = Service_Security::getInstance()->getInfoFromSessionId(Core_ApiRequest::getInstance()->getSessID());
		if (! $info) {
			throw new Exception_Yiban(Lang_Zh_Common::SESSID_ERROR, 106);
		}
		$coin = $this->params['coin'];
		//用户转增乐享豆操作
		$rs = Service_Pay::getInstance()->rollOutCoin($info['userid'],$this->params['userid'],$coin);
		if(!is_array($rs)){
			$content = $info['username'].'赠送给您 '.$coin.'个乐享豆！';
			Service_Message::getInstance()->sendMsg($info['userid'],$this->params['userid'],$content,3);
			$content2 ='已收到 '.$coin.'个乐享豆！';
			Service_Message::getInstance()->sendMsg($this->params['userid'],$info['userid'],$content2,3);
			return array('reslut'=>1);
		}else{
			throw new Exception_Yiban($rs['message'],101);
		}
	}
	public function paramRules ()
	{
		return array(
				'userid' => array (
						'validators' => array (
								new Core_Validator_ApiNotEmpty ()
						)
				),
				'coin' => array(
						'validators' => array(
								new Core_Validator_ApiNumeric()
						)
				),
				'content' => array(
						'default' => ''
				)
		);
	}
}