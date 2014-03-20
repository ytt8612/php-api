<?php

class Core_Validator_ApiNotNull implements Core_Validator_ApiInterface{
    public function isValid($data){
        return null !== $data;
    }
}
