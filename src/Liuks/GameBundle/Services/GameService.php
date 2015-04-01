<?php

namespace Liuks\GameBundle\Services;


use Liuks\GameBundle\Entity\Games;
use Symfony\Component\DependencyInjection\ContainerAware;

class GameService extends ContainerAware
{
    public function getCurrentGame($table_id)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        return $em->getRepository('LiuksGameBundle:Games')->findOneBy(['table' => $table_id], ['startTime' => 'DESC']);
    }

    /**
     * @param $table_id
     * @return Games
     */
    public function newGame($table_id)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $shake = $em->getRepository('LiuksTableBundle:Tableshake')->findOneBy(['table' => $table_id]);
        $game = $em->getRepository('LiuksGameBundle:Games')->findOneBy(['table' => $table_id, 'startTime' => $shake->getLastShake()]);
        $table = $em->getReference('LiuksTableBundle:Tables', $table_id);
        $start_time = $shake->getLastShake();
        if (!$game)
        {
            if ($start_time == 0)
            {
                $start_time = time();
                $shake->setLastShake($start_time);
                $em->flush($shake);
            }
            $game = new Games();
            $game->setStartTime($start_time);
            $game->setTable($table);
            $game->setGoals(0, 0);
            $game->setGoals(0, 1);
            $game->setEndTime(0);
        }
        return $game;
    }

    /**
     * @param $table_id
     * @param $team
     * @param $player
     * @param $user
     * @return Games
     */
    public function addPlayer($table_id, $team, $player, $user)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $game = $this->newGame($table_id);
        $position = $team*2 + $player + 1;
        if (!$game->getUser($position))
        {
            $game->setUser($user, $position);
        }
        $em->persist($game);
        $em->flush($game);
        return $game;
    }

    /**
     * @param $table_id
     * @param $team
     * @return Games
     */
    public function calculatePoints($table_id, $team)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $game = $this->newGame($table_id);

        $game->setGoals($game->getGoals($team)+1, $team); //TODO: temporary saving (prevent update on every goal).

        $em->flush($game);
        return $game;
    }
}