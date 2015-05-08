<?php

namespace Liuks\GameBundle\Services;

use Liuks\GameBundle\Events\ApiResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class DataService extends ContainerAware
{
    /**
     * @param $api
     * @param $last_id
     * @return mixed
     */
    public function getData($api, $last_id)
    {
        if ($api) {
            $url = $api."?rows=100&from-id=".$last_id;
            $response = $this->getResponse($url);

            return $this->parseData($response);
        }

        return null;
    }

    /**
     * @param $url
     * @return mixed
     */
    private function getResponse($url)
    {
        $username = 'nfq';
        $password = 'labas';

        $options = [
            CURLOPT_USERPWD => $username.':'.$password,
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER => false,  // don't return headers
            CURLOPT_ENCODING => "",     // handle compressed
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT => 120,    // time-out on response
            CURLOPT_FOLLOWLOCATION => true
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    /**
     * @param $response
     * @return mixed
     */
    private function parseData($response)
    {
        $apiEvent = new ApiResponseEvent();
        $apiEvent->setResponse($response);

        $dispatcher = $this->container->get('event_dispatcher');

        $data = json_decode($response);

        if (!$data || $data->status != 'ok') {
            $dispatcher->dispatch($apiEvent::APIERROR, $apiEvent);
        }

        foreach ($data->records as $record) {
            if ($record->data) {
                $record->data = json_decode($record->data);
            }
        }

        $dispatcher->dispatch($apiEvent::APISUCCESS, $apiEvent);

        return $data->records;
    }
}
