<?php

ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';

$userIdConverter = function ($id) {
    // you can easily define any converter
    // and assign it to a variable,
    // then pass this variable to be used
    // in the converter. Adding 0 to not alter the value
    // but this shows how you can write converter.
    return (int)$id + 0;
};

//annon's code
//note the ->convert() code is used to
//apply conversion to input parameters like $id or whatever
//this is good as the converter can be of its own method
//and actual json response code does not need to be concerned
//with conversion.  this is good abstraction.
$app['debug'] = true;


// setting up database connection
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'user'     => 'root',
        'password' => 'peichieh',
        'dbname'   => 'test',
        'charset'  => 'utf8'
    ),
));

// set up routing for test/id
$app->get('/test/{id}', function ($id) use ($app) {
    // finds the record from the database matching supplied id
    $sql = "SELECT * FROM test_table WHERE id = ?";
    $test = $app['db']->fetchAssoc($sql, array((int) $id));

    // return record in json format
    if ($test == false)
        return $app->json(array("error", "no record found."));
    return $app->json($test);
})->convert('id', $userIdConverter);

require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';
$app->run();
