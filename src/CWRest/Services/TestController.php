<?php
namespace CWRest\Services;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestController
{
    protected $notesService;

    public function __construct($service)
    {
        $this->notesService = $service;
    }

    public function getOne($id)
    {
        return new JsonResponse($this->notesService->getOne($id));
    }

    public function getAll()
    {
        return new JsonResponse($this->notesService->getAll());
    }

    public function save(Request $request)
    {

        $note = $this->getDataFromRequest($request);
        return new JsonResponse(array("id" => $this->notesService->save($note)));

    }

    public function update($id, Request $request)
    {
        $note = $this->getDataFromRequest($request);
        $this->notesService->update($id, $note);
        return new JsonResponse($note);

    }

    public function delete($id)
    {

        return new JsonResponse($this->notesService->delete($id));

    }

    public function getDataFromRequest(Request $request)
    {
        return $note = array(
            "test" => $request->request->get("test")
        );
    }
}