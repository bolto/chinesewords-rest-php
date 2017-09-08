<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 06/09/17
 * Time: 10:51 PM
 */

namespace CWRest\Services;


class ServiceBase
{
    protected $db;
    protected $table_name;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getTableName()
    {
        if ($this->table_name == null || $this->table_name == ""){
            throw new Exception("ServiceBase's child class instance's table name must be declared.");
        }
        return $this->table_name;
    }

    public function getOne($id)
    {
        return $this->db->fetchAssoc("SELECT * FROM " . $this->getTableName() . " WHERE id=?", array((int)$id));
    }

    public function getAll($limit = 0)
    {
        $query = "SELECT * FROM " . $this->getTableName();
        if ($limit > 0)
            $query = $query . " limit $limit";
        return $this->db->fetchAll($query);
    }

    function save($object)
    {
        $this->db->insert($this->getTableName(), $object);
        return $this->db->lastInsertId();
    }

    function update($id, $object)
    {
        return $this->db->update($this->getTableName(), $object, ['id' => $id]);
    }

    function delete($id)
    {
        return $this->db->delete($this->getTableName(), array("id" => $id));
    }
}