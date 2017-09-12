<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 06/09/17
 * Time: 10:45 PM
 */

namespace CWRest\Services;


class WordPingyingService extends ServiceCustom
{
    protected $db;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->selectOneQuery =
            "SELECT * "
            . "FROM pingying p "
            . "  INNER JOIN word_pingying wp ON p.id = wp.pingying_id "
            . "WHERE wp.word_id = ? AND wp.pingying_id = ?";
        $this->selectAllQuery =
            "SELECT * "
            . "FROM pingying p "
            . "  INNER JOIN word_pingying wp ON p.id = wp.pingying_id "
            . "WHERE wp.word_id = ?";
    }
}