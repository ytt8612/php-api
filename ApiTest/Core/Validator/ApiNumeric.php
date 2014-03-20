<?php 
class Core_Validator_ApiNumeric implements Core_Validator_ApiInterface{
    public function isValid($data){
        return is_numeric($data);
    }
}
?>