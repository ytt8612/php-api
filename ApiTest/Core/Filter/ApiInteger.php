<?php

class Core_Filter_ApiInteger implements Core_Filter_ApiInterface
{
    public $bigInt = true;

    public function __construct($bigInt = true) {
        $this->bigInt = $bigInt;
    }

    public function execute ($data)
    {
        return $this->bigInt ? gmp_strval($data) : intval($data);
    }
}