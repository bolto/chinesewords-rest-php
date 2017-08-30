<?php

ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';

//annon's code
$app['debug'] = true;
$app->get('/test', function () use ($blogPosts) {
    $output = '';
    foreach ($blogPosts as $post) {
        $output .= $post['title'];
        $output .= '<br />';
    }

    return $output;
});

require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';
$app->run();
