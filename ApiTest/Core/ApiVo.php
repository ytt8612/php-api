<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Core_ApiVo {

    CONST RENDER_NONE = 'NONE';

    public static function outputFilter($data) {
        array_walk_recursive($data, function(&$item, $key) {
                    if (is_bool($item)) {
                        $item = (true === $item) ? 'true' : 'false';
                    }elseif (is_null($item)){
                        $item = '';
                    }elseif (is_string($item)) {
                   //     $item = iconv("GBK","UTF-8//TRANSLIT//IGNORE",$item);
                 //       $item = mb_convert_encoding($item, "UTF-8", "GBK");
                    }elseif (is_numeric($item)){
                        $item = strval($item);
                    }
                });
        return $data;
    }

    public static function render($data){
        if ($data == self::RENDER_NONE){

        }else{
            return self::renderJson($data);
        }
    }

    public static function renderJson($data)
    {
    	 $do = Core_ApiRequest::getInstance()->getCmd();
        $ret = array('response' => '100','message' => '请求成功', 'data' => self::outputFilter((array)$data),'sessID'=>Core_ApiRequest::getInstance()->getSessID());
        $json = json_encode($ret, true);
   
        return $json;
    }

    public static function processArray(array $data)
    {
        $ret = array();
        foreach ($data as $d){
            $ret[] = static::process($d);
        }
        return $ret;
    }



}
