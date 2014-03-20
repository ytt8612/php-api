<?php
/**
 * 登陆接口
 * @author anneyan
 * 
 */
class App_Security_Login extends Core_ApiApplication {

	public function run() {
		$rs = Service_Security::getInstance()->login(iconv("UTF-8","GBK//IGNORE",$this->params['username']), $this->params['password']);

		if($rs){
			if(isset($rs['code'])){
				throw new Exception_Yiban($rs['msg'],$rs['code']);
			}
			return $rs;
		}else{
			throw new Exception_Yiban(Lang_Zh_Common::LOGIN_ERROR,101);
		}
	}

	public function paramRules() {
		return array(
				'username' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				),
				'password' => array(
						'validators' => array(
								new Core_Validator_ApiNotEmpty()
						)
				)
		);
	}

}
