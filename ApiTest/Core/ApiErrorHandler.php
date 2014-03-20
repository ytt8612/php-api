<?php

class Core_ApiErrorHandler {

    public static function init() {
        set_error_handler(array('Core_ApiErrorHandler', 'exceptionHandler'));
    }

    public static function exceptionHandler($errno, $errstr, $errfile, $errline, $errcontext) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

}
