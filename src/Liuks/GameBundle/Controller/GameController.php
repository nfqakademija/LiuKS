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
        $update->setLastId(end($records)->id);
        $em->flush($update);

        $records = $this->get('api_data.service')->getData($table->getApi(), $update->getLastId());
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
                    }
                    else
                    {
                        if ($shake->getLastShake() == 0)
                        {
                            $shake->setLastShake($record->timeSec);
                        }
                        //TODO: set lastShake to 0 every 1 minute
                    }
                    $em->flush($shake);
                    break;
                case "AutoGoal":
                    $this->get('game_utils.service')->calculatePoints($table_id, $record->data->team, $action_time);
                    break;
                case "CardSwipe":
                    $user = $em->getRepository('LiuksUserBundle:Users')->findOneBy(['cardId' => $record->data->card_id]);
                    if (!$user)
                    {
                        //TODO: naujo userio sukūrimas (event arba service)
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

        $game = $this->get('game_utils.service')->getCurrentGame($table_id);
        return $this->render('LiuksGameBundle:Default:data.html.twig', ['game' => $game, 'shake' => $shake->getLastShake(), 'action' => $action]);
    }
}