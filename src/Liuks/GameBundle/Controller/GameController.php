<?php

namespace Liuks\GameBundle\Controller;

use Liuks\TableBundle\Entity\Tableupdate;
use Liuks\TableBundle\Entity\Tableshake;
use Liuks\TableBundle\Entity\Tables;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    public function dataAction($table_id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        //later we will take table_id based on what api we are pulling data from
        $table = $em->getRepository('LiuksTableBundle:Tables')->find($table_id);
        if (!$table)
        {
            throw $this->createNotFoundException('Ooops, it looks like this table is in another dimension...');
        }

        $update = $em->getRepository('LiuksTableBundle:Tableupdate')->findOneBy(['table' => $table_id]);
        if (!$update)
        {
            $update = new Tableupdate();
            $update->setTable($table);
            $update->setLastId(1);
            $em->persist($update);
            $em->flush($update);
        }

        $records = $this->get('api_data.service')->getData($table->getApi(), $update->getLastId());
        if (!$records)
        {
            throw $this->createNotFoundException('Ooops, it looks like this table API is down...');
        }
        else
        {
            $shake = $em->getRepository('LiuksTableBundle:Tableshake')->findOneBy(['table' => $table_id]);
            $action = ''; //for debug
            foreach ($records as $record)
            {
                $action = $record->type;
                $action_time = $record->timeSec;
                switch ($record->type)
                {
                    case "TableShake":
                        if (!$shake)
                        {
                            $shake = new Tableshake();
                            $shake->setTable($table);
                            $shake->setLastShake($action_time);
                            $em->persist($shake);
                            $em->flush($shake);
                        }
                        else
                        {
                            if ($shake->getLastShake() == 0)
                            {
                                $shake->setLastShake($record->timeSec);
                                $em->flush($shake);
                            }
                            //TODO: set lastShake to 0 every 1 minute
                        }
                        break;
                    case "AutoGoal":
                        $this->get('game_utils.service')->calculatePoints($table_id, $record->data->team, $action_time);
                        break;
                    case "CardSwipe":
                        $user = $em->getRepository('LiuksUserBundle:Users')->findOneBy(['cardId' => $record->data->card_id]);
                        if (!$user)
                        {
                            //TODO: naujo userio sukūrimas (redirect arba service)
                        }
                        else
                        {
                            $this->get('game_utils.service')->addPlayer($table_id, $record->data->team, $record->data->player, $user);
                        }
                        break;
                    default:
                        break;
                }
            }
            $update->setLastId(end($records)->id);
            $em->flush($update);

            $game = $this->get('game_utils.service')->getCurrentGame($table_id);
            return $this->render('LiuksGameBundle:Default:data.html.twig', ['game' => $game, 'shake' => $shake->getLastShake(), 'action' => $action]);
        }

    }
}