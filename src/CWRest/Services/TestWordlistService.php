<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 06/09/17
 * Time: 10:45 PM
 */

namespace CWRest\Services;


class TestWordlistService extends ServiceCustom
{
    protected $db;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->table_name = "test_wordlist";
        $this->selectOneQuery =
            "SELECT * "
            . "FROM wordlist wl "
            . "  INNER JOIN test_wordlist tw ON wl.id = tw.wordlist_id "
            . "WHERE tw.test_id = ? AND wl.id = ?";
        $this->selectAllQuery =
            "SELECT * "
            . "FROM wordlist wl "
            . "  INNER JOIN test_wordlist tw ON wl.id = tw.wordlist_id "
            . "WHERE tw.test_id = ?";
    }

    function associate($id1, $id2)
    {
        $this->db->insert($this->getTableName(), ["test_id"=>$id1, "wordlist_id"=>$id2]);
        return $this->db->lastInsertId();
    }
    function delete($id1, $id2)
    {
        return $this->db->delete($this->getTableName(), ["test_id"=>$id1, "wordlist_id"=>$id2]);
    }
}