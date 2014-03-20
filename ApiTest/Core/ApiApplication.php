<?php

abstract class Core_ApiApplication {

    /**
     *
     * @var Core_Request
     */
    public $request;
    public $params;

    public function __construct($request) {
        $this->request = $request;
        $this->params = $this->getParams();
    }
    //put your code here
    abstract function run();

    abstract function paramRules();

    public function defaultParams(){
        return array();
    }

    public function getParams(){
        $ret = array();

        $rules = array_merge($this->paramRules(), $this->defaultParams());

        foreach ($rules as $key => $rules){
            $default = isset($rules['default']) ? $rules['default'] : null;
            $val = $this->request->getParam($key, $default);

            $Validator = new Core_ApiValidator();
            $Filter = new Core_ApiFilter();
            if (!isset($rules['default'])){
                $Validator->addValidator(new Core_Validator_ApiNotNull());
            }

            if (!empty($rules['validators'])){
                $Validator->addValidators($rules['validators']);
            }

            if(!$Validator->isValid($val)){
                throw new InvalidArgumentException("Invalid Param [{$key}]");
            }

            if (!empty($rules['filters'])){
                $Filter->setData($val);
                $Filter->setFilters($rules['filters']);
                $val = $Filter->execute();
            }

            $ret[$key] = $val;
        }
        return $ret;
    }

}
