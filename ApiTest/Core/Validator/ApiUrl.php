<?php

class Core_Validator_ApiUrl implements Core_Validator_ApiInterface{

    public function isValid($url){
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
    }
}
