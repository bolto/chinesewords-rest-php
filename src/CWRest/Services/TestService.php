<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 05/09/17
 * Time: 11:10 PM
 */

namespace CWRest\Services;


class TestService
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getOne($id)
    {
        return $this->db->fetchAssoc("SELECT * FROM test_table WHERE id=?", [(int) $id]);
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM test_table");
    }

    function save($note)
    {
        $this->db->insert("test", $note);
        return $this->db->lastInsertId();
    }

    function update($id, $note)
    {
        return $this->db->update('test', $note, ['id' => $id]);
    }

    function delete($id)
    {
        return $this->db->delete("test", array("id" => $id));
    }

}