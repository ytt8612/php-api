<?php
class Core_ApiConfig {

    protected static $_config;

    public static function init()
    {
        $global = include PROJECT_PATH . 'Config' . DIRECTORY_SEPARATOR . 'config.global.php';
        $env = include PROJECT_PATH . 'Config' . DIRECTORY_SEPARATOR . 'config.' . ENV . '.php';
        self::$_config = array_merge($global, $env);
    }

    public static function get($keystr = '', $default = null){
        $node = &self::$_config;
        if ($keystr){
            $keys = explode('.', $keystr);
            foreach ($keys as $key){
                if (isset($node[$key])){
                    $node = &$node[$key];
                }else{
                    return $default;
                }
            }
        }
        return $node;
    }
}
