<?php

class App_Security_Authcode extends Core_ApiApplication {

    public function run() {
    	$info = Service_Security::getInstance ()->getInfoFromSessionId ( Core_ApiRequest::getInstance ()->getSessID () );
    	if (!Lib_Util::is_mobile($this->params['phone'])) {
    		throw new Exception_Yiban ( Lang_Zh_Common::PHONE_ERROR, 101 );
    	}
    	if (1==$this->params['type']) {
    		if (! $info) {
    			throw new Exception_Yiban ( Lang_Zh_Common::SESSID_ERROR, 106 );
    		}
    		$ret_send = Service_Security::getInstance()->sendAuthCode($this->params['phone'],$info['userid']);
    	}else{
    	  $ret_send = Service_Security::getInstance()->sendAuthCode($this->params['phone']);
    	}
    	if(!empty($ret_send)){
    		if ($ret_send['send']==1) {
    		return $ret_send;
    		}else if ($ret_send['send']==2) {
    			throw new Exception_Yiban(Lang_Zh_Common::AUTH_CODE_Limit,101);
    		}else {
    		throw new Exception_Yiban(Lang_Zh_Common::ACTION_ERROR,101);
    	  }
    	}else{
    		throw new Exception_Yiban(Lang_Zh_Common::ACTION_ERROR,101);
    	}
    	
    }

    public function paramRules() {
        return array(
            'phone' => array(
                'validators' => array(
                    new Core_Validator_ApiNotEmpty()
                )
            ),
        		'type' => array(
        				'default' => '0'
        		)
        );
    }

}
