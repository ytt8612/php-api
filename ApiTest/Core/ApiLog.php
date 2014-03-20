<?php

class Core_ApiLog {

    public static function log($var, $name = 'log', $line_delimiter = "\n")
    {
    	$time = date("Y-m-d",time());
    	if(ENV=='prd'){
    		$fp = fopen('/tmp/bbscache/apierrorlog/' . $name.$time . '.log', 'a');
    	}else{
        	$fp = fopen(PROJECT_PATH . 'Log/' . ENV . '/' . $name.$time . '.log', 'a');
    	}
        if (!is_string($var)){
            $var = var_export($var, true);
        }
        fwrite($fp, $var . $line_delimiter);
        fclose($fp);
    }
    
	public static function logDataBase($ct, $userid, $do,$request, $pic, $responsecode,$response)
    {
        $model_log = new Model_Client_Op_Log();
        $arr = array('ct' => $ct, 'userid' => $userid, 'do' => $do, 'request' => $request,'pic' => $pic, 'responsecode' => $responsecode,'response'=>$response,'time'=>date('Y-m-d H:i:s'));
        $model_log->add($arr);
    }
    
    
}