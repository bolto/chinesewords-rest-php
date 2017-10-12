<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 07/09/17
 * Time: 1:25 AM
 */

namespace CWRest\Services;


use Symfony\Component\HttpFoundation\JsonResponse;

class WordlistWordUpdateController extends ControllerCustom
{
    public function __construct($service)
    {
        parent::__construct($service);
    }

    /**
     * The id in table worldlist_word is required to update the record.
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        $object = $this->getDataFromRequest($request);
        $this->dataService->update($id, $object);
        return new JsonResponse($object);
    }
}