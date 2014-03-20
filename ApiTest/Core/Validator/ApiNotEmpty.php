<?php

class Core_Validator_ApiNotEmpty implements Core_Validator_ApiInterface{
    public function isValid($data){
        return !empty($data);
    }
}
