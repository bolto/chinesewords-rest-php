<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 06/09/17
 * Time: 10:45 PM
 */

namespace CWRest\Services;


class PingyingCharacterService extends ServiceBase
{
    protected $db;

    public function __construct($db)
    {
        $this->table_name = "pingying_character";
        parent::__construct($db);
    }
    public function getAll($limit = 0)
    {

        return parent::getAll($limit);
    }
}