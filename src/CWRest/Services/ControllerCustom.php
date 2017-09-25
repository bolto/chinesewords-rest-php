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
    protected $dataService;

    public function __construct($dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * @param $id1 (note this name must match api resource name, for example:
     *              /resource/{id1}/moreresource/{id2} ...etc)  This is because
     *              this Silex framework uses reflection to initialize/map/assign params.
     * @param $id2 (note this name must match api resource name, for example:
     *              /resource/{id1}/moreresource/{id2} ...etc)  This is because
     *              this Silex framework uses reflection to initialize/map/assign params.
     * @return JsonResponse
     */
    public function getOne($id1, $id2)
    {
        return new JsonResponse ($this->dataService->getOne($id1, $id2));
    }

    /**
     * @param $id1 (note this name must match api resource name, for example:
     *              /resource/{id1}/moreresource/{id2} ...etc)  This is because
     *              this Silex framework uses reflection to initialize/map/assign params.
     * @return JsonResponse
     */
    public function getAll($id1)
    {
        return new JsonResponse($this->dataService->getAll($id1));
    }

    public function associate($id1, $id2)
    {
        return new JsonResponse($this->dataService->associate($id1, $id2));
    }

    public function delete($id1, $id2)
    {
        return new JsonResponse($this->dataService->delete($id1, $id2));
    }
}