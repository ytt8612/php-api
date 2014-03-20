<?php

class Core_Validator_ApiArray implements Core_Validator_ApiInterface
{
    public $validator;

    public function __construct(Core_Validator_ApiInterface $validator) {
        $this->validator = $validator;
    }

    public function isValid ($data)
    {
        $isValid = true;
        foreach ((array)$data as $d){
            $isValid = $isValid && $this->validator->isValid($d);
        }
        return $isValid;
    }
}