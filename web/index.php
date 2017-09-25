<?php
use CWRest\Services\TestController;
use CWRest\Services\TestControllerProvider;

ini_set('display_errors', -1);

require_once __DIR__.'/../vendor/autoload.php';
define("ROOT_PATH", __DIR__ . "/..");

$app = new Silex\Application();

require __DIR__ . '/../config/prod.php';
require __DIR__.'/../src/app.php';

$app['debug'] = true;

$app['http_cache']->run();