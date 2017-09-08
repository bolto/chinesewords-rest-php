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
    protected $db;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->selectOneQuery = "SELECT * FROM wordlist_word wl INNER JOIN word w ON wl.word_id = w.id WHERE wl.wordlist_id = ? and w.id = ?";
        $this->selectAllQuery = "SELECT * FROM wordlist_word wl INNER JOIN word w ON wl.word_id = w.id WHERE wl.wordlist_id = ?";
    }
}