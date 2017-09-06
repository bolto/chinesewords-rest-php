<?php
namespace CWRest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserConverter
{
    public function convert($id)
    {
        // when $id is empty, in terms of rest request,
        // it may be that we should return full list of user ids
        // but for now, this is just testing that we can check
        // null/empty id and throw errors.
        if (null == $id || $id == ""){
            throw new NotFoundHttpException(sprintf('User id is empty'));
        }
        return $id;
    }
}