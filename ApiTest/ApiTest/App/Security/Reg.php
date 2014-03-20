<?php

class App_Security_Reg extends Core_ApiApplication {

    public function run() {
    	
    	$is_mail = Lib_Util::is_email($this->params['email']);
    	if(!empty($this->params['email']) &&!$is_mail){
    		throw new Exception_Yiban(Lang_Zh_Common::EMAIL_ERROR,101);
    	}
    	$ret = Service_Security::getInstance()->register($this->params['username'], $this->params['password'],$this->params['email'], $this->params['phone_num']);
       if($ret){
       	return array('userid'=>$ret);
       }else{
       		throw new Exception_Yiban(Lang_Zh_Common::REG_ERROR,101);
       }
    }
    public function paramRules() {
        return array(
            'username' => array(
                'validators' => array(
                    new Core_Validator_ApiNotEmpty()
                )
            ),
            'email' => array(
                'default' => ''
            ),
            'password' => array(
                'validators' => array(
                    new Core_Validator_ApiNotEmpty()
                )
            ),
            'phone_num' => array(
                  'default' => 0
            )
        );
    }

}
