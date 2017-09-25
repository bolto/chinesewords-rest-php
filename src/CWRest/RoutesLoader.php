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

    /**
     * Instantiate controllers and store them in $app
     */
    public function instantiateControllers()
    {
        // for each table, there will be a REST API name mapped to it
        foreach ($this->serviceNames as $serviceName) {
            $tableRestApiMeta = new TableRestApiMeta($serviceName);
            // instantiating controller with corresponding service object retrieved from $app's hashmap
            // and store controller instances in $app's hashmap
            $this->app[$tableRestApiMeta->getControllerAppKey()] = function() use ($tableRestApiMeta) {
                $controllerClassName = $tableRestApiMeta->getControllerClassName();
                return new $controllerClassName($this->app[$tableRestApiMeta->getServiceAppKey()]);
            };
        }
    }

    /**
     * Return API base and version string to be used for mapping REST controllers to the correct API url.
     * For example: this function may return "api/v1" so that it can be used to
     * form http://your-domain.com/api/v1/
     * @return string
     */
    private function getRestApiVersionUriSuffix(){
        return $this->app["api.endpoint"] . '/' . $this->app["api.version"] . "/";
    }

    /**
     * Return API resource suffix.  Notice in controllers, there are methods like getAll, getOne ... etc.
     *
     * For example, http://localhost/api/v1/word/4
     * The suffix part is: "/word/"
     *
     * For example, http://localhost/api/v1/wordlist/4/word
     * The suffix part is: "/wordlsit/{id1}/word/"
     *
     * @param $serviceNames
     * @return string
     */
    private function createGetAllApiResourceSuffix($serviceNames){
        $suffix = "";
        for($index = 0, $size = count($serviceNames); $index < $size; $index++){
            if($index > 0){
                $name = $serviceNames[$index];
                $suffix .= "/$name";
            }

            if ($index < $size - 1){
                $suffix .= "/{id" . (($size > 1)? (string)($index+1):"") . "}";
            }
        }
        return $suffix;
    }

    /**
     * Return API resource suffix.
     *
     * For example, http://localhost/api/v1/word/4
     * The suffix part is: "/word/{id}"
     *
     * For example, http://localhost/api/v1/wordlist/4/word
     * The suffix part is: "/wordlsit/{id1}/word/{id2}"
     *
     * @param $serviceNames
     * @return string
     */
    private function createGetOneApiResourceSuffix($serviceNames){
        $suffix = "";
        for($index = 0, $size = count($serviceNames); $index < $size; $index++){
            if ($index > 0){
                $name = $serviceNames[$index];
                $suffix .= "/$name";
            }
            $suffix .= "/{id" .(($size > 1)? (string)($index+1):""). "}";
        }
        return $suffix;
    }

    public function bindRoutesToControllers()
    {
        foreach ($this->serviceNames as $service) {
            $tableRestApiMeta = new TableRestApiMeta($service);
            $controllerAppKey = $tableRestApiMeta->getControllerAppKey();
            if (!is_array($service))
            {
                $api = $this->app["controllers_factory"];
                $api->get('/', "$controllerAppKey:getAll");
                $api->get('', "$controllerAppKey:getAll");
                $api->get('/{id}', "$controllerAppKey:getOne");
                $api->get('/{id}/', "$controllerAppKey:getOne");
                $api->post('/', "$controllerAppKey:save");
                $api->post('', "$controllerAppKey:save");
                $api->put('/{id}', "$controllerAppKey:update");
                $api->delete('/{id}', "$controllerAppKey:delete");
                $this->app->mount($this->getRestApiVersionUriSuffix() . $service, $api);
            }else{
                $getOneApiResourceUrl = $this->createGetOneApiResourceSuffix($service);
                $getAllApiResourceUrl = $this->createGetAllApiResourceSuffix($service);
                $api->get($getAllApiResourceUrl, "$controllerAppKey:getAll");
                $api->get($getAllApiResourceUrl . "/", "$controllerAppKey:getAll");
                $api->get($getOneApiResourceUrl, "$controllerAppKey:getOne");
                $api->post($getAllApiResourceUrl, "$controllerAppKey:save");
                $api->post($getAllApiResourceUrl . "/", "$controllerAppKey:save");
                $api->put($getOneApiResourceUrl, "$controllerAppKey:associate");
                $api->delete($getOneApiResourceUrl, "$controllerAppKey:delete");
                $this->app->mount($this->getRestApiVersionUriSuffix() . $service[0], $api);
            }
        }
    }
}