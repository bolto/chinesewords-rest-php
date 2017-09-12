<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 07/09/17
 * Time: 1:18 AM
 */

namespace CWRest\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

class ControllerBase
{
    protected $dataService;

    public function __construct($dataService)
    {
        $this->dataService = $dataService;
    }

    public function getOne($id)
    {
        return new JsonResponse($this->dataService->getOne($id));
    }

    public function getAll()
    {
        return new JsonResponse($this->dataService->getAll());
    }

    public function save(Request $request)
    {
        $object = $this->getDataFromRequest($request);
        return new JsonResponse(array("id" => $this->dataService->save($object)));
    }

    public function update($id, Request $request)
    {
        $object = $this->getDataFromRequest($request);
        $this->dataService->update($id, $object);
        return new JsonResponse($object);
    }

    public function delete($id)
    {
        return new JsonResponse($this->dataService->delete($id));
    }
}