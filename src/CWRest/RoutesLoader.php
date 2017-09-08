<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 04/09/17
 * Time: 6:00 PM
 */

namespace CWRest;

use Silex\Application;

class RoutesLoader
{
    private $app;
    private $serviceNames;

    public function __construct(Application $app, array $serviceNames)
    {
        $this->app = $app;
        $this->serviceNames = $serviceNames;
        $this->instantiateControllers();
    }

    public function instantiateControllers()
    {
        foreach ($this->serviceNames as $serviceName) {
            $this->app[$serviceName . '.controller'] = function() use ($serviceName) {
                $controllerClassName = 'CWRest\Services\\' . ucfirst($serviceName) . 'Controller';
                return new $controllerClassName($this->app[$serviceName . '.service']);
            };
        }
        $serviceName = "wordlistword";
        $this->app[$serviceName . '.controller'] = function() use ($serviceName) {
            $controllerClassName = 'CWRest\Services\\' . 'WordlistWord' . 'Controller';
            return new $controllerClassName($this->app[$serviceName . '.service']);
        };
    }

    public function bindRoutesToControllers()
    {
        foreach ($this->serviceNames as $service) {
            $api = $this->app["controllers_factory"];
            $api->get('/', $service . ".controller:getAll");
            $api->get('/{id}', $service . ".controller:getOne");
            $api->post('/', $service . ".controller:save");
            $api->put('/{id}', $service . ".controller:update");
            $api->delete('/{id}', $service . ".controller:delete");
            $this->app->mount($this->app["api.endpoint"] . '/' . $this->app["api.version"] . "/" . $service, $api);
        }
        $service = "wordlistword";
        $api = $this->app["controllers_factory"];
        $api->get('/{id}/word', $service . ".controller:getAll");
        $api->get('/{id1}/word/{id2}', $service . ".controller:getOne");
        $this->app->mount($this->app["api.endpoint"] . '/' . $this->app["api.version"] . "/" . "wordlist", $api);
    }
}