<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 09/09/17
 * Time: 2:27 AM
 */

namespace CWRest;

/**
 * Return a list of meta objects containing controller and service names for each table or joined tables.
 * For example, to define a REST service, the following names are needed for setting up REST API for a table
 * (or joined tables).
 * Single table: test
 * Controller name: TestController
 * Service name: TestService
 * Service API: /test
 *
 * Joined table: wordlist and word
 * Controller name: WordlistWordController
 * Service name: WordlistWordService
 * Service API: /wordlist/{id1}/word
 *
 * Args:
 *     tableRelation: a table name or a list of table names joined together
 */
class TableRestApiMeta{
    protected $tableList;
    protected $controllerClassName;
    protected $serviceClassName;
    protected $serviceAppKey;
    protected $controllerAppKey;
    public $NAMESPACE =  'CWRest\Services\\';

    function __construct($tableList) {
        $this->tableList = $tableList;
        $this->controllerClassName = $this->createControllerClassName($tableList);
        $this->serviceClassName = $this->createServiceClassName($tableList);
        $tableRestApiKeyPrefix = $this->createClassPrefix($tableList);
        $this->serviceAppKey = strtolower($tableRestApiKeyPrefix) . ".service";
        $this->controllerAppKey = strtolower($tableRestApiKeyPrefix) . ".controller";
    }

    /**
     * @return string
     */
    public function getControllerAppKey()
    {
        return $this->controllerAppKey;
    }

    /**
     * @return mixed
     */
    public function getServiceAppKey()
    {
        return $this->serviceAppKey;
    }

    /**
     * @return string
     */
    public function getControllerClassName()
    {
        return $this->controllerClassName;
    }

    /**
     * @return string
     */
    public function getServiceClassName()
    {
        return $this->serviceClassName;
    }

    private function createClassPrefix($tableList){
        $tables = [];
        if (!is_array($tableList)){
            array_push($tables, $tableList);
        }else{
            $tables = $tableList;
        }
        $className = "";
        foreach($tables as $table){
            $className .= $this->formatTableName($table);
        }
        return $className;
    }

    private function formatTableName($tableName){
        // make sure table names with "_" are formatted so that, for example,
        // pingying_character is formatted to PingyingCharacter
        $names = explode("_", $tableName);
        $formattedName = "";
        foreach($names as $name){
            $formattedName .= ucfirst($name);
        }
        return $formattedName;
    }

    private function createControllerClassName($tableList){
        return  $this->NAMESPACE . $this->createClassPrefix($tableList) . "Controller";
    }

    private function createServiceClassName($tableList){
        return $this->NAMESPACE . $this->createClassPrefix($tableList) . "Service";
    }
}
