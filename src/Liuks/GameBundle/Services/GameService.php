<?php

namespace Liuks\GameBundle\Services;


use Liuks\GameBundle\Entity\Games;
use Symfony\Component\DependencyInjection\ContainerAware;

class GameService extends ContainerAware
{
    /**
     * @param $table_id
     * @return Games
     */
    public function getCurrentGame($table_id)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        return $em->getRepository('LiuksGameBundle:Games')->findOneBy(['table' => $table_id, 'endTime' => 0], ['startTime' => 'DESC']);
    }

    /**
     * @param $table_id
     * @return Games
     */
    public function newGame($table_id)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $shake = $em->getRepository('LiuksTableBundle:Tableshake')->findOneBy(['table' => $table_id]);
        $game = $em->getRepository('LiuksGameBundle:Games')->findOneBy(['table' => $table_id, 'startTime' => $shake->getLastShake(), 'endTime' => 0]);

        if (!$game)
        {
            $table = $em->getRepository('LiuksTableBundle:Tables')->find($table_id);
            $table->setFree(false);
            $em->flush($table);

            $start_time = $shake->getLastShake();
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
            $em->persist($game);
            $em->flush($game);
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
        $game = $this->getCurrentGame($table_id);
        if (!$game)
        {
            $game = $this->newGame($table_id);
        }
        $position = $team*2 + $player;
        if (!$game->getUser($position))
        {
            $game->setUser($user, $position);
        }
        $em->flush($game);
        return $game;
    }

    /**
     * @param $table_id
     * @param $team
     * @param $action_time
     * @return Games
     */
    public function calculatePoints($table_id, $team, $action_time)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $game = $this->getCurrentGame($table_id);
        if (!$game)
        {
            $game = $this->newGame($table_id);
        }
        $goals = $game->getGoals($team) + 1;
        $game->setGoals($goals, $team); //TODO: temporary saving (prevent update on every goal).
        $game = $this->resolveGame($game, $team, $action_time);

        $em->flush($game);
        return $game;
    }

    /**
     * @param $game Games
     * @param $winner_side
     * @param $action_time
     * @return Games
     */
    private function resolveGame($game, $winner_side, $action_time)
    {
        if ($game->getGoals($winner_side) == 10)
        {
            $em = $this->container->get('doctrine.orm.default_entity_manager');
            $game->setEndTime($action_time);

            $uid = $winner_side*2;
            for ($i = 0; $i < 4; $i++)
            {
                $user = $game->getUser($i);
                if ($user)
                {
                    $user->setGamesPlayed($user->getGamesPlayed()+1);
                    if ($i == $uid || $i == $uid+1)
                    {
                        $user->setGamesWon($user->getGamesWon()+1);
                    }
                }
                $em->flush($user);
            }

            $table = $game->getTable();
            $table->setFree(true);
            $em->flush($table);

            $shake = $em->getRepository('LiuksTableBundle:Tableshake')->findOneBy(['table' => $table->getId()]);
            $shake->setLastShake(0);
            $em->flush($shake);

        }
        return $game;
    }
}