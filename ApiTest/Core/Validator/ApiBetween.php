<?php

/**
 *
 * @author superx
 */
class Core_Validator_ApiBetween implements Core_Validator_ApiInterface{
    public $min = null;
    public $max = null;

    public function __construct($min = null, $max = null) {
        $this->min = $min;
        $this->max = $max;
    }

    public function isValid($data){
        $ret = true;
        if ($this->min !== null){
            $ret = $ret && ($data >= $this->min);
        }
        if ($this->max !== null){
            $ret = $ret && ($data <= $this->max);
        }
        return $ret;
    }
}
