<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 07/09/17
 * Time: 1:18 AM
 */

namespace CWRest\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

class ControllerCustom
{
    protected $apiRoot;
    protected $dataService;

    public function __construct($dataService)
    {
        $this->dataService = $dataService;
    }

    public function getApiRoot()
    {
        if ($this->apiRoot == null || $this->apiRoot =="")
            throw new Exception("ControllerBase's child class instance's api root must be declared.");
        return $this->apiRoot;
    }

    public function getOne($id1, $id2)
    {
        return new JsonResponse($this->dataService->getOne($id1, $id2));
    }

    public function getAll($id)
    {
        return new JsonResponse($this->dataService->getAll($id));
    }

    public function getDataFromRequest(Request $request)
    {
        return $object = array(
            $this->getApiRoot() => $request->request->get($this->getApiRoot())
        );
    }
}