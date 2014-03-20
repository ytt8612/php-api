<?php

class Core_Db_ApiConnection {

    protected static $_stack = array();

    private function __construct() {
    }

    /**
     * @param string $name
     * @return PDO
     */
    public static function getInstance($name = 'default') {
        if (empty(self::$_stack[$name])) {
            $conf = Core_ApiConfig::get('db.' . $name);
            self::$_stack[$name] = new PDO($conf['dsn'], $conf['username'], $conf['passwd'], array(
                //a bug for PDO::MYSQL_ATTR_INIT_COMMAND
                        1002 => 'SET NAMES '. $conf['charset'])
            );
        }
        return self::$_stack[$name];
    }

}
