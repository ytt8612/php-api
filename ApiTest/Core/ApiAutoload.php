<?php

class Core_ApiAutoload {
    public function __construct(){

    }

    public static function registerAutoload () {
        spl_autoload_register(array(
            'Core_ApiAutoload' ,
            'autoload'));
    }

    public static function autoload ($class) {
    	if (file_exists(PROJECT_PATH."/Classes/".$class.".php"))
		{
			require PROJECT_PATH."/Classes/".$class.".php"; 
		}
		elseif(file_exists(CORE_PATH."../application/models/".$class.".php"))
		{
			require CORE_PATH."../application/models/".$class.".php"; 
		}
        $class = str_replace('_', DIRECTORY_SEPARATOR, $class);
        if (strpos($class, 'Core' . DIRECTORY_SEPARATOR) === 0){
            require CORE_PATH . $class . '.php';
        }
    	
		
    	else{
            $file = PROJECT_PATH . $class . '.php';
            if (file_exists($file)){
                require $file;
            }
        }
    }
}
