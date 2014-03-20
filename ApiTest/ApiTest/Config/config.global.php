<?php

return array(
    'mcryptKey' => 'key', 
	   'weiboApi' => array(
        'key' => '4059843102',
        'secret' => 'd6658c0981d54241a776cad5dcad6336'
    ),
		'db' => array(
				//default is required
				'default' => array(
						'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=enjoy',
						'username' => 'root',
						'passwd' => '',
						'charset' => 'utf8',
				),
		),
		'memcahe' => array(
				'default' => array(
					 1=>array('server' =>"10.21.118.243",'port'=>'60000'),
		  )
		)
);