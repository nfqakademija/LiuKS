<?php

namespace Liuks\TableBundle\Services;


use Symfony\Component\DependencyInjection\ContainerAware;

class TableService extends ContainerAware
{
    /**
     * @param \Liuks\TableBundle\Entity\Table $table
     * @param $record
     * @return bool
     */
    public function handleTableAction($table, $record)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $action = $record->type;
        $action_time = $record->timeSec;
        switch ($action)
        {
            case "TableShake":
                if ($table->getFree() && ($table->getLastShake() == 0 || $action_time - $table->getLastShake() >= 60))
                {
                    $table->setLastShake($action_time);
                }
                break;
            case "AutoGoal":
                $this->container->get('game_utils.service')->calculatePoints($table->getId(), $record->data->team, $action_time);
                break;
            case "CardSwipe":
                $user = $em->getRepository('LiuksUserBundle:User')->findOneBy(['cardId' => $record->data->card_id]);
                if (!$user)
                {
                    //TODO: create new user (event or service)
                }
                else
                {
                    $this->container->get('game_utils.service')->addPlayer($table->getId(), $record->data->team, $record->data->player, $user);
                }
                break;
            default:
                return false;
                break;
        }
        return true;
    }

    /**
     * @param float $lat
     * @param float $long
     * @return array|\Liuks\TableBundle\Entity\Table[]
     */
    public function findClosestTables($lat, $long)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $tables = $em->getRepository('LiuksTableBundle:Table')->findAll();
        $t = [];
        $R = 6371000; // gives d in metres
        $latU = deg2rad($lat);
        $longU = deg2rad($long);
        foreach ($tables as $table)
        {
            $latT = deg2rad($table->getLat());
            $longT = deg2rad($table->getLong());
            $x = ($longT - $longU) * cos(($latU + $latT)/2);
            $y = $latT - $latU;
            $t[$table->getId()] = ['dist' => sqrt($x*$x + $y*$y) * $R, 'table' => $table];
        }
        asort($t);
        $t = array_slice($t, 0, 5);
        $tables = array_column($t, 'table');

        return $tables;
    }
}