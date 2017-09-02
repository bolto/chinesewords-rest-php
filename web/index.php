<?php

ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';

$userIdConverter = function ($id) {
    // you can easily define any converter
    // and assign it to a variable,
    // then pass this variable to be used
    // in the converter.
    return (int)$id + 2;
};

//annon's code
//note the ->convert() code is used to
//apply conversion to input parameters like $id or whatever
//this is good as the converter can be of its own method
//and actual json response code does not need to be concerned
//with conversion.  this is good abstraction.
$app['debug'] = true;
$app->get('/test/{id}', function ($id){
    // note the function ($id) can also
    // be defined to cast input variable to a class instance
    // eg: function (User $user)
    return "hello: $id.";
})->convert('id', $userIdConverter);

require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';
$app->run();
