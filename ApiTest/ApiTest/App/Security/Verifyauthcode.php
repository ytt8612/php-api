<?php

class App_Security_Verifyauthcode extends Core_ApiApplication {

    public function run() {
    	//验证码验证code
    	$ret_ve = Service_Security::getInstance()->verifyAuthCode($this->params['phone'],$this->params['authcode']);

    	
    	if($ret_ve){
    		return $ret_ve;
    	}else{
    		throw new Exception_Yiban(Lang_Zh_Common::AUTHCODE_ERROR,101);
    	}
        
    }

    public function paramRules() {
        return array(
            'phone' => array(
                'validators' => array(
                    new Core_Validator_ApiNotEmpty()
                )
            ),
            'authcode' => array(
                'validators' => array(
                    new Core_Validator_ApiNotEmpty()
                )
            ),
        );
    }

}
