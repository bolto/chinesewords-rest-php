<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 06/09/17
 * Time: 10:51 PM
 */

namespace CWRest\Services;


use Symfony\Component\Config\Definition\Exception\Exception;

class ServiceCustom
{
    protected $db;
    protected $selectOneQuery;
    protected $selectAllQuery;

    public function __construct($db)
    {
        $this->db = $db;
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
}