<?php

namespace Liuks\GameBundle\Events;


use Symfony\Component\EventDispatcher\Event;

class ApiResponseEvent extends Event
{
    const APIERROR = 'api_response_error_event';
    const APISUCCESS = 'api_response_success_event';

    /**
     * @var mixed
     */
    private $response;

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }


}