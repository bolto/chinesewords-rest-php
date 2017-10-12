<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 06/09/17
 * Time: 10:45 PM
 */

namespace CWRest\Services;


class WordlistWordUpdateService extends ServiceCustom
{
    public function __construct($db)
    {
        parent::__construct($db);
        $this->table_name = "wordlist_word";
    }
    function updatePingying($wordlistWordId, $pingyingId)
    {
        $query = "UPDATE wordlist_word SET pingying_id = :? WHERE id = :?";
        return $this->db->fetchAll($query, [(int) $wordlistWordId, (int)$pingyingId]);
    }
}