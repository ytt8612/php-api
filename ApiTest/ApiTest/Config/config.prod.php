<?php

return array(
	'db' => array(
        //default is required
        'default' => array(
            'dsn' => 'mysql:host='.SAE_MYSQL_HOST_M.';port='.SAE_MYSQL_PORT.';dbname='.SAE_MYSQL_DB,
            'username' => SAE_MYSQL_USER,
            'passwd' => SAE_MYSQL_PASS,
            'charset' => 'utf8',
        ),
    ),

);