<?php

// configure your app for the production environment
$app['log.level'] = Monolog\Logger::ERROR;
$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

// setting up database connection
$app['db.options'] = array(
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'user'     => 'root',
        'password' => 'peichieh',
        'dbname'   => 'chinesewords',
        'charset'  => 'UTF8'
  //'driverOptions'  => array('1002'=> "SET NAMES 'UTF8' COLLATE 'utf8_general_ci'")
);

$app['api.version'] = "v1";
$app['api.endpoint'] = "/api";