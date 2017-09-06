<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 04/09/17
 * Time: 4:48 AM
 */
namespace CWRest;

use CWRest\Services\TestService;
use Silex\Application;


class ServicesLoader
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bindServicesIntoContainer()
    {
        $this->app['test.service'] = function() {
            return new TestService($this->app["db"]);
        };
    }
}