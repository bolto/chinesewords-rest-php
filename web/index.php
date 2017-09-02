<?php

ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';

//annon's code
//note the ->convert() code is used to
//apply conversion to input parameters like $id or whatever
//this is good as the converter can be of its own method
//and actual json response code does not need to be concerned
//with conversion.  this is good abstraction.
$app['debug'] = true;
$app->get('/test/{id}', function ($id){

    return "hello: $id.";
})->convert('id', function ($id) { return (int) $id + 1; });

require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';
$app->run();
