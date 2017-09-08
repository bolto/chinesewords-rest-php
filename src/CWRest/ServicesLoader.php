<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 04/09/17
 * Time: 4:48 AM
 */
namespace CWRest;

use Silex\Application;


class ServicesLoader
{
    protected $app;
    protected $service_names;

    public function __construct(Application $app, array $service_names)
    {
        $this->app = $app;
        $this->service_names = $service_names;
    }

    public function bindServicesIntoContainer()
    {
        foreach ($this->service_names as $service)
        {
            $className = 'CWRest\Services\\' . ucfirst($service) . "Service";
            $this->app[$service . '.service'] = function() use ($className) {
                return new $className($this->app["db"]);
            };

        }
    }
}