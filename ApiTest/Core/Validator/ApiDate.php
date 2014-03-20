<?php

class Core_Validator_ApiDate implements Core_Validator_ApiInterface{
    public $format;

    public function __construct($format = 'Y-m-d') {
        $this->format = $format;
    }

    public function isValid($data){
        return date($this->format, strtotime($data)) == $data;
    }
}
