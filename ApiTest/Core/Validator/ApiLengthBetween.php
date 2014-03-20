<?php

class Core_Validator_ApiLengthBetween implements Core_Validator_ApiInterface{
    public $min = 0;
    public $max = 0;
    public $encoding = 'utf-8';
    
    public function __construct($min, $max) {
        $this->min = $min;
        $this->max = $max;
    }
    
    public function isValid($data){
        $length = mb_strlen($data, $this->encoding);
        return ($length > $this->min && $length < $this->max);
    }
}
