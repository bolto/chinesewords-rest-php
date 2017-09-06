<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 04/09/17
 * Time: 6:00 PM
 */

namespace CWRest;
use CWRest\Services\TestController;
use Silex\Application;

class RoutesLoader
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();
    }

    private function instantiateControllers()
    {
        $this->app['test.controller'] = function() {
            return new TestController($this->app['test.service']);
        };
    }

    public function bindRoutesToControllers()
    {
        $api = $this->app["controllers_factory"];

        $api->get('/', "test.controller:getAll");
        $api->get('/{id}', "test.controller:getOne");
        $api->post('/', "test.controller:save");
        $api->put('/{id}', "test.controller:update");
        $api->delete('/{id}', "test.controller:delete");
        //$this->app->mount('/test/', $api);
        $this->app->mount($this->app["api.endpoint"].'/'.$this->app["api.version"]."/test", $api);
    }
}