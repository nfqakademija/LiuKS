<?php

namespace Liuks\GameBundle\Services;


class DataService
{
    public function getData($api, $last_id)
    {
        $url = $api."?rows=10&from-id=".$last_id;
        //$response = $this->getResponse($url);
        $response = $this->getTestData($last_id);

        return $this->parseData($response);
    }

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

    private function parseData($response)
    {
        $data = json_decode($response);

        if (!$data || $data->status != 'ok')
        {
            //error, because API is down.
            return null;
        }
        else
        {
            foreach ($data->records as $record)
            {
                if ($record->data)
                {
                    $record->data = json_decode($record->data);
                }
            }
            return $data->records;
        }
    }

    private function getTestData($last_id)
    {
        $response = '
            {"status":"ok","records":[
                {"id":"164118","timeSec":"1425543907","usec":"855616","type":"TableShake","data":"[]"},
                {"id":"164119","timeSec":"1425543997","usec":"303637","type":"CardSwipe","data":"{\u0022team\u0022:0,\u0022player\u0022:1,\u0022card_id\u0022:4255291}"},
                {"id":"164120","timeSec":"1425544003","usec":"277164","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164121","timeSec":"1425544030","usec":"32589","type":"TableShake","data":"[]"},
                {"id":"164122","timeSec":"1425544090","usec":"18399","type":"TableShake","data":"[]"},
                {"id":"164123","timeSec":"1425544092","usec":"95366","type":"TableShake","data":"[]"},
                {"id":"164124","timeSec":"1425544098","usec":"498654","type":"TableShake","data":"[]"},
                {"id":"164125","timeSec":"1425544105","usec":"375143","type":"TableShake","data":"[]"},
                {"id":"164126","timeSec":"1425544130","usec":"375143","type":"TableShake","data":"[]"},
                {"id":"164127","timeSec":"1425544150","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164128","timeSec":"1425544151","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:1}"},
                {"id":"164129","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164130","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164131","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164132","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164133","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164134","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164135","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164136","timeSec":"1425544155","usec":"97852","type":"AutoGoal","data":"{\u0022team\u0022:0}"},
                {"id":"164137","timeSec":"1425544200","usec":"196820","type":"TableShake","data":"[]"}
            ]}
        ';

        $data = json_decode($response);
        $records = [];
        foreach ($data->records as $record)
        {
            if ($record->id > $last_id)
            {
                $records[] = $record;
            }
        }
        if (count($records) > 0)
        {
            $data->records = [$records[0]];
        }
        else
        {
            $data = null;
        }
        return json_encode($data);
    }
}