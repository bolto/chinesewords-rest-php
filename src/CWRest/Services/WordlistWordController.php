<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 07/09/17
 * Time: 1:25 AM
 */

namespace CWRest\Services;

class WordlistWordController extends ControllerCustom
{
    public function __construct($service)
    {
        $this->apiRoot = "wordlist";
        parent::__construct($service);
    }
}