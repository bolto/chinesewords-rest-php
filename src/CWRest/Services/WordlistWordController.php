<?php
/**
 * Created by PhpStorm.
 * User: annon
 * Date: 07/09/17
 * Time: 1:25 AM
 */

namespace CWRest\Services;


use Symfony\Component\HttpFoundation\JsonResponse;

class WordlistWordController extends ControllerCustom
{
    public function __construct($service)
    {
        parent::__construct($service);
    }

    /**
     * Overriding parent method to include pingying data and all possible pingyings for the word.
     * The reason to return these additional data is so it is way cheaper and faster to load these
     * data in one go, rather than for each pingying a separate REST call.
     *
     * @param $id1 (note this name must match api resource name, for example:
     *              /resource/{id1}/moreresource/{id2} ...etc)  This is because
     *              this Silex framework uses reflection to initialize/map/assign params.
     * @return JsonResponse
     */
    public function getAll($id1)
    {
        $wordlistWords = $this->dataService->getAll($id1);
        $db = $this->dataService->db();
        // query to get the pingying of this wordlistWord
        // Wordlist word should have a fixed pingying, because a word in a wordlist has context and therefore
        // it should have a fixed pingying.  Although a word can potentially have multiple pingyings depending on
        // usage/context.
        $pingyingQuery = "SELECT * FROM pingying p WHERE p.id = ?";
        // query to get all possible pingyings of this word
        $pingyingsQuery = "SELECT * FROM pingying p INNER JOIN word_pingying wp on p.id = wp.pingying_id WHERE wp.word_id = ?";
        for($i = 0; $i < count($wordlistWords); $i++){
            $wordlistWord = $wordlistWords[$i];
            // get pingying for the word
            $pingying = $db->fetchAssoc($pingyingQuery, array((int)$wordlistWord['pingying_id']));
            $wordlistWords[$i]['pingying'] = $pingying;
            // get all possible pingyings for the word
            $pingyings = $db->fetchAll($pingyingsQuery, array((int)$wordlistWord['word_id']));
            $wordlistWords[$i]['pingyings'] = $pingyings;
        }
        return new JsonResponse($wordlistWords);
    }
    public function update($id, Request $request)
    {
        $object = $this->getDataFromRequest($request);
        $this->dataService->update($id, $object);
        return new JsonResponse($object);
    }
}