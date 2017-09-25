<?php
use CWRest\ServicesLoader;
use CWRest\RoutesLoader;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;


//$app = new Application();
date_default_timezone_set('Europe/London');

//accepting JSON
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'.'; charset=UTF-8'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...  Ab178598001

    return $twig;
});

$app->register(new DoctrineServiceProvider(), array(
    "db.options" => $app["db.options"]
));

$app->register(new HttpCacheServiceProvider(), array("http_cache.cache_dir" => ROOT_PATH . "/storage/cache",));

$app->register(new MonologServiceProvider(), array(
    "monolog.logfile" => ROOT_PATH . "/storage/logs/" . Carbon::now('Europe/London')->format("Y-m-d") . ".log",
    "monolog.level" => $app["log.level"],
    "monolog.name" => "application"
));

// list of services to load
$service_names = ["wordlist", "word", "test", "profile", "assignment", "tone", "pingying", "pingying_character", ["word", "pingying"], ["wordlist", "word"], ["test", "wordlist"]];

// custom load services start
$servicesLoader = new ServicesLoader($app, $service_names);
$servicesLoader->bindServicesIntoContainer();
// custom load services end

// custom load routes start
$routesLoader = new RoutesLoader($app, $service_names);
$routesLoader->bindRoutesToControllers();
// custom load routes end

$app->error(function (\Exception $e, $code) use ($app) {
    $app['monolog']->addError($e->getMessage());
    $app['monolog']->addError($e->getTraceAsString());
    return new JsonResponse(array("statusCode" => $code, "message" => $e->getMessage(), "stacktrace" => $e->getTraceAsString()));
});

$app->after(
    function (Request $request, Response $response) {
        $response->headers->set('Content-Type', $response->headers->get('Content-Type') . '; charset=UTF-8');
        //$response->headers->set('Access-Control-Allow-Headers', 'x-requested-with, x-file-name, x-index, x-total, x-hash, Content-Type, origin, authorization, accept, client-security-token');
        //$response->headers->set('Access-Control-Allow-Origin', '*');
        if ($response instanceof JsonResponse) {
            $response->setEncodingOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        return $response;
    }
);
return $app;
