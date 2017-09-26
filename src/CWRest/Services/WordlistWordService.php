<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 06/09/17
 * Time: 10:45 PM
 */

namespace CWRest\Services;


class WordlistWordService extends ServiceCustom
{
    public function __construct($db)
    {
        parent::__construct($db);
        $this->table_name = "wordlist_word";
        $this->selectOneQuery = "SELECT * FROM word w inner join wordlist_word wl on wl.word_id = w.id WHERE wl.wordlist_id = ? and w.id = ?";
        $this->selectAllQuery = "SELECT * FROM word w inner join wordlist_word wl on wl.word_id = w.id WHERE wl.wordlist_id = ?";
    }
}