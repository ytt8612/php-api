<?php

class Core_Validator_ApiEmail implements Core_Validator_ApiInterface{
    
    public function isValid($data){
        return filter_var($data, FILTER_VALIDATE_EMAIL);
    }
}
