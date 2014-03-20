<?php

class Core_ApiDispatcher {

    public static function dispatch () {
    	try{
    		$request = Core_ApiRequest::getInstance();
    	}
    	catch(Exception $e){
            $log ='[' . date('Y-m-d H:i:s') . "]==============================================================>\n";
            $log .= var_export(Core_ApiRequest::getJson(), true);
            $log .= "\n------------------------------------------------------------------------------------\n";
            $log .= $e->getMessage() . "\n" . $e->getFile() . ' Line ' . $e->getLine() . "\n" . $e->getTraceAsString();
            $log .= "\n<===================================================================================\n\n";
            Core_ApiLog::log($log, 'sysError');
            header('HTTP/1.1 200 Error:' . $e->getMessage(), true, 200);

            if ( !($code = $e->getCode()) ) {
                $code = '101';
            }
            header("Content-Type: text/html; charset=utf-8");
            echo json_encode(array('response' => (string)$code, 'message' =>$e->getMessage()));
            exit();
        }
        if($request->isTask()){
        	self::dispatchCli();
        }else{
        	self::dispatchCgi();
        }
    }

    public static function dispatchCli()
    {
        try{
            Core_ApiConfig::init();
            Core_ApiErrorHandler::init();
            $request = Core_ApiRequest::getInstance();
            $cmd = $request->getCmd();

            $class = 'Task_' . implode('_', array_map('ucfirst', explode('_', $cmd)));
            if (!file_exists(PROJECT_PATH . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php')){
                throw new BadMethodCallException('Invalid DO');
            }
            $app = new $class($request);
            $app->run();
            echo "\nSuccess\n";
            exit(0);
        }catch(Exception $e){
            $log ='[' . date('Y-m-d H:i:s') . "]==============================================================>\n";
            $log .= var_export(Core_ApiCli::getInstance()->getParams(), true);
            $log .= "\n------------------------------------------------------------------------------------\n";
            $log .= $e->getMessage() . "\n" . $e->getFile() . ' Line ' . $e->getLine() . "\n" . $e->getTraceAsString();
            $log .= "\n<===================================================================================\n\n";
           Core_ApiLog::log($log, 'cliError');
            echo "\nError\n";
            exit(1);
        }
    }

    public static function dispatchCgi () {
        try{
            Core_ApiConfig::init();
            Core_ApiErrorHandler::init();
            $request = Core_ApiRequest::getInstance();
            $cmd = $request->getCmd();
			$ct = $request->getCt();
			$req = $request->getJson();
            $class = 'App_' . implode('_', array_map('ucfirst', explode('_', $cmd)));
            if (!file_exists(PROJECT_PATH . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php')){
                throw new BadMethodCallException('Invalid Do');
            }
            $app = new $class($request);
            $ret = $app->run();
            header("Content-Type: text/html; charset=utf-8");
            $json = Core_ApiVo::render($ret);
        	$sid = $request->getSessID();
            if(!empty($sid)){
            	$info = Service_Security::getInstance ()->getSessionIdInfo ( $sid );
            	if(!$info){
            		$userid = 0;
            	}else{
            		$userid = $info['userid'];
            	}
            }else{
            	$userid = 0;
            }
        	$pic =0;
            if($request->isMultipart()){
            	$pic =1;
            }
            $responsecode =100;
            //Core_ApiLog::logDataBase($ct, $userid, $cmd,json_encode($req), $pic, $responsecode,$json);
            echo $json;
        }catch(Exception $e){
            $log ='[' . date('Y-m-d H:i:s') . "]==============================================================>\n";
            $log .= var_export(Core_ApiRequest::getJson(), true);
            $log .= "\n------------------------------------------------------------------------------------\n";
            $log .= $e->getMessage() . "\n" . $e->getFile() . ' Line ' . $e->getLine() . "\n" . $e->getTraceAsString();
            $log .= "\n<===================================================================================\n\n";
            Core_ApiLog::log($log, 'sysError');
            header('HTTP/1.1 200 Error:' . $e->getMessage(), true, 200);

            if ( !($code = $e->getCode()) ) {
                $code = '101';
            }
            $request = Core_ApiRequest::getInstance();
            $cmd = $request->getCmd();
			      $ct = $request->getCt();
			      $req = $request->getJson();
            header("Content-Type: text/html; charset=utf-8");
        	$sid = $request->getSessID();
            if(!empty($sid)){
            	$info = Service_Security::getInstance ()->getSessionIdInfo ( $sid );
            	if(!$info){
            		$userid = 0;
            	}else{
            		$userid = $info['userid'];
            	}
            }else{
            	$userid = 0;
            }
        	$pic =0;
            if($request->isMultipart()){
            	$pic =1;
            }
            $responsecode =$code;
//            Core_ApiLog::logDataBase($ct, $userid, $cmd,json_encode($req), $pic, $e->getMessage() . "\n" . $e->getFile() . ' Line ' . $e->getLine() . "\n" . $e->getTraceAsString());
            echo json_encode(array('response' => (string)$code, 'message' =>$e->getMessage()));
        }

    }


}