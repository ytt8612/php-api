<?php

class Core_ApiDebugLog extends Core_ApiLog {

    public static function log($var, $name = 'debug', $line_delimiter = "\n")
    {
        if (ENV != 'prod'){
            parent::log($var, $name, $line_delimiter);
        }
    }
}