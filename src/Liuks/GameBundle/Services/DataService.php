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
        if ($api)
        {
            $url = $api."?rows=10&from-id=".$last_id;
            //$response = $this->getResponse($url);
            $response = $this->getTestData($last_id);
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

        $options = array(
            CURLOPT_USERPWD        => $username.':'.$password,
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
            CURLOPT_FOLLOWLOCATION => true
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $response  = curl_exec($ch);

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

        if (!$data || $data->status != 'ok')
        {
            $dispatcher->dispatch($apiEvent::APIERROR, $apiEvent);
        }

        foreach ($data->records as $record)
        {
            if ($record->data)
            {
                $record->data = json_decode($record->data);
            }
        }

        $dispatcher->dispatch($apiEvent::APISUCCESS, $apiEvent);

        return $data->records;
    }

    /**
     * @param $last_id
     * @return bool|string
     */
    private function getTestData($last_id)
    {
        $response = '
            {"status":"ok","records":[
                {"id":"164118","timeSec":"1425543907","usec":"855616","type":"TableShake","data":"[]"},
                {"id":"164119","timeSec":"1425543997","usec":"303637","type":"CardSwipe","data":"{\u0022team\u0022:0,\u0022player\u0022:1,\u0022card_id\u0022:4255291}"},
                {"id":"164120","timeSec":"1425544003","usec":"277164","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164121","timeSec":"1425544030","usec":"32589","type":"TableShake","data":"[]"},
                {"id":"164122","timeSec":"1425544090","usec":"18399","type":"TableShake","data":"[]"},
                {"id":"164123","timeSec":"1425544150","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164124","timeSec":"1425544151","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164125","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164126","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164127","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164128","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164129","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164130","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164131","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164132","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164133","timeSec":"1425544200","usec":"196820","type":"TableShake","data":"[]"},
                {"id":"164134","timeSec":"1425545844","usec":"855616","type":"TableShake","data":"[]"},
                {"id":"164135","timeSec":"1425545850","usec":"303637","type":"CardSwipe","data":"{\u0022team\u0022:0,\u0022player\u0022:1,\u0022card_id\u0022:4255291}"},
                {"id":"164136","timeSec":"1425545860","usec":"855616","type":"TableShake","data":"[]"},
                {"id":"164137","timeSec":"1425545870","usec":"303637","type":"CardSwipe","data":"{\u0022team\u0022:1,\u0022player\u0022:0,\u0022card_id\u0022:4248132}"},
                {"id":"164138","timeSec":"1425555871","usec":"855616","type":"TableShake","data":"[]"},
                {"id":"164139","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164140","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164141","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164142","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164143","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164144","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164145","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164146","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164147","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164148","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164149","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164150","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164151","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164152","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164153","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164154","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164155","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164156","timeSec":"1425556000","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164157","timeSec":"1425556001","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"}
            ]}
        ';

        $data = json_decode($response);
        $records = [];
        $count = 0;
        foreach ($data->records as $record)
        {
            if ($record->id > $last_id && $count < 1)
            {
                $records[] = $record;
                $count++;
            }
        }
        if (count($records) > 0)
        {
            $data->records = $records;
        }
        else
        {
            return false;
        }
        return json_encode($data);
    }
}