<?php

$env = ($env = getenv('ENV')) ? $env : 'dev';

$config = array(
	'dev' => array(
		'APP_ID' => 123,
		'APP_SECRET' => 'secret',
		'REDIRECT_URI' => 'http://localhost/facebooklogin'
	),
	'prod' => array(
	)
);

$config = $config[$env];
