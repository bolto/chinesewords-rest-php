<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 07/09/17
 * Time: 1:25 AM
 */

namespace CWRest\Services;


class ProfileController extends ControllerBase
{
    public function __construct($service)
    {
        $this->apiRoot = "profile";
        parent::__construct($service);
    }
}