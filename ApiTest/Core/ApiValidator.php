<?php

class Core_ApiValidator {
    private $_result = true;
    private $_finalResult = true;
    private $_errors;
    private $_stack = array();

    public function getErrors () {
        return $this->_errors;
    }

    public function isValid($value){
        foreach ($this->_stack as $validator){
            $this->_result = $validator->isValid($value);
//            $this->_errors[] = $validator->getError();
            $this->_finalResult = $this->_result && $this->_finalResult;
        }
        return $this->_finalResult;
    }

    public function addValidator($validator){
        $this->_stack[] = $validator;
    }

    public function addValidators(array $validators){
        $this->_stack = array_merge($this->_stack, $validators);
    }

    public function setValidators(array $validators){
        $this->_stack = $validators;
    }

}
?>