<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 06/09/17
 * Time: 10:45 PM
 */

namespace CWRest\Services;


class WordlistService extends ServiceBase
{
    protected $db;

    public function __construct($db)
    {
        $this->table_name = "wordlist";
        parent::__construct($db);
    }
}