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
    protected $serviceNames;

    public function __construct(Application $app, array $serviceNames)
    {
        $this->app = $app;
        $this->serviceNames = $serviceNames;
    }

    public function bindServicesIntoContainer()
    {
        foreach ($this->serviceNames as $service) {
            $tableRestApiMeta = new TableRestApiMeta($service);
            if (count($service)> 2){
                throw new Exception(
                    "Chained resources of 3 or more is not supported yet.  Resources: " . implode(", ", $service));
            }
            $this->app[$tableRestApiMeta->getServiceAppKey()] = function () use ($tableRestApiMeta) {
                $serviceClassName = $tableRestApiMeta->getServiceClassName();
                return new $serviceClassName($this->app["db"]);
            };
        }
    }
}