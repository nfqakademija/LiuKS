<?php

namespace Liuks\GameBundle\EventListeners;


use Liuks\GameBundle\Events\ApiResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiResponseEventListener
{
    public function onApiResponseError(ApiResponseEvent $event)
    {
        throw new NotFoundHttpException('Ooops, it looks like this table API is down...');
    }

    public function onApiResponseSuccess(ApiResponseEvent $event)
    {

    }
}