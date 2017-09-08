<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 07/09/17
 * Time: 1:25 AM
 */

namespace CWRest\Services;


class TestController extends ControllerBase
{
    public function __construct($service)
    {
        $this->apiRoot = "test";
        parent::__construct($service);
    }
}