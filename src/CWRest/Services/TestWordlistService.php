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
}