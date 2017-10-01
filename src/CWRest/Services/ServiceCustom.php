<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 06/09/17
 * Time: 10:51 PM
 */

namespace CWRest\Services;


use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class ServiceCustom, this class is used for REST APIs that are nested.
 * Eg: http://api_url/service_1/id_1/service_2/id_2
 *
 * Note this class does not inherit from ServiceBase as function overloading isn't
 * working quite like Java.  Therefore, ServiceCustom is its own class entirely.
 *
 * @package CWRest\Services
 */
class ServiceCustom
{
    protected $db;
    protected $table_name;
    protected $selectOneQuery;
    protected $selectAllQuery;
    protected $updateQuery;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Making db available so controller can access it for customizing JSON output.  Note each controller is coupled
     * with a service.  If controller needs to customize JSON output, for example, to add more data than the default
     * query results, it can use the db to make additional queries and add them to returned JSON object.
     *
     * @return mixed
     */
    public function db()
    {
        return $this->db;
    }
    public function getTableName()
    {
        if ($this->table_name == null || $this->table_name == ""){
            throw new Exception("ServiceCustom's child class instance's table name must be declared.");
        }
        return $this->table_name;
    }

    protected function getOneQuery()
    {
        if ($this->selectOneQuery == null || $this->selectOneQuery == "")
        {
            throw new Exception("Member variable selectOneQuery must be declared.");
        }
        return $this->selectOneQuery;
    }

    protected function getAllQuery()
    {
        if ($this->selectAllQuery == null || $this->selectAllQuery == "")
        {
            throw new Exception("Member variable selectAllQuery must be declared.");
        }
        return $this->selectAllQuery;
    }

    public function getOne($id1, $id2)
    {
        return $this->db->fetchAssoc($this->getOneQuery(), array((int)$id1, (int)$id2));
    }

    public function getAll($id)
    {
        $query = $this->getAllQuery();

        return $this->db->fetchAll($query, [(int) $id]);
    }

    function associate($id1, $id2)
    {
        throw new Exception("Not implemented.");
    }
    function delete($id1, $id2)
    {
        throw new Exception("Not implemented.");
    }
}