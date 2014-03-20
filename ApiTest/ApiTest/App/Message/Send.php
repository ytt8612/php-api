<?php
/**
 * 发私信接口
 * @author 严廷廷
 */
class App_Message_Send extends Core_ApiApplication
{

	public function run ()
	{
		$info = Service_Security::getInstance()->getInfoFromSessionId(Core_ApiRequest::getInstance()->getSessID());
		if (! $info) {
			throw new Exception_Yiban(Lang_Zh_Common::SESSID_ERROR, 106);
		}
		$content = '';
		if (isset($this->params['content'])){
			$content = $this->params['content'];
			$content = addslashes($content);
		}
		$clenght = Lib_Util::getStrLen($content);
		
		$type = isset($this->params['type']) ? intval($this->params['type']) : 1;
		
			if (empty($clenght)) {
				throw new Exception_Yiban(Lang_Zh_Common::CONTENT_EMPTY_ERROR, 105);
			} else {
				if ($clenght > 300) {
					throw new Exception_Yiban(Lang_Zh_Common::CONTENT_LENGHT_ERROR,
							105);
				}
			}
			$msg_id = Service_Message::getInstance()->sendMsg($info['userid'],$this->params['userid'],$content,$this->params['type'],$this->params['mid']);
			if($msg_id){
				return array('msg_id'=>$msg_id);
			}else{
				throw new Exception_Yiban(Lang_Zh_Common::ACTION_ERROR, 101);
			}
			
	}
	public function paramRules ()
	{
		return array(
				'userid' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				),
				'content' => array(
						'default' => ''
				),
				'type' => array(
						'default' => '1'
				),
				'mid' => array(
						'default' => '0'
				)
		);
	}
}