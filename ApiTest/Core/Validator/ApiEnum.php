<?php

class Core_Validator_ApiEnum implements Core_Validator_ApiInterface{
    public $values = array();
    public $strict = false;
    
    public function __construct($values, $strict = false) {
        $this->min = $values;
        $this->max = $strict;
    }
    
    public function isValid($data){
        return in_array($data, $this->values, $this->strict);
    }
}