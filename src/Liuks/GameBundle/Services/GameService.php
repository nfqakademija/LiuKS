<?php

namespace Liuks\GameBundle\Services;

use Liuks\GameBundle\Entity\Game;
use Liuks\GameBundle\Entity\Match;
use Liuks\GameBundle\Events\GameStatusEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class GameService extends ContainerAware
{
    /**
     * @param $table_id
     * @return Match|Game|null
     */
    public function getCurrentGame($table_id)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $tournament = $em->getRepository('LiuksGameBundle:Tournament')->findOneBy(['table' => $table_id, 'endTime' => 0]);
        if ($tournament)
        {
            $game = $em->getRepository('LiuksGameBundle:Match')->findOneBy(['tournament' => $tournament, 'endTime' => 0]);
        }
        else
        {
            $game = $em->getRepository('LiuksGameBundle:Game')->findOneBy(['table' => $table_id, 'endTime' => 0]);
        }
        if ($game)
        {
            return $game;
        }
        return null;
    }

    /**
     * @param $table_id
     * @return Game|Match
     */
    public function newGame($table_id)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $table = $em->getRepository('LiuksTableBundle:Table')->find($table_id);
        $start_time = $table->getLastShake();
        $tournament = $em->getRepository('LiuksGameBundle:Tournament')->findOneBy(['table' => $table_id, 'endTime' => 0]);
        if ($tournament)
        {
            $game = $em->getRepository('LiuksGameBundle:Match')->findOneBy(['tournament' => $tournament, 'endTime' => 0]);
        }
        else
        {
            $game = $em->getRepository('LiuksGameBundle:Game')->findOneBy(['table' => $table_id, 'endTime' => 0]);
        }
        if (!$game)
        {
            if ($start_time == 0)
            {
                $start_time = time();
                $table->setLastShake($start_time);
                $em->flush($table);
            }

            if ($tournament)
            {
                $round = $tournament->getCurrentRound();
                if ($round == -1)
                {
                    $round = 1; //match for 3rd place
                }
                $competitors = $em->getRepository('LiuksGameBundle:Competitor')->findBy(
                    ['tournament' => $tournament, 'round' => $round],
                    ['matchup' => 'ASC'], 2);
                if ($competitors[0]->getMatchup() == $competitors[1]->getMatchup())
                {
                    $game = new Match();
                    $game->setTournament($tournament);
                    $game->setRound($tournament->getCurrentRound());
                    $game->setMatchup($competitors[0]->getMatchup());
                    $game->setCompetitor1($competitors[0]);
                    $game->setCompetitor2($competitors[1]);
                }
                else
                {
                    //this should not happen
                    return null;
                }
            }
            else
            {
                $game = new Game();
                $game->setTable($table);
            }
            $game->setGoals(0, 0);
            $game->setGoals(0, 1);
            $game->setStartTime($start_time);
            $game->setEndTime(0);
            $em->persist($game);
            $em->flush($game);

            $gameEvent = new GameStatusEvent();
            $gameEvent->setTable($table);
            $this->container->get('event_dispatcher')->dispatch($gameEvent::GAMECREATED, $gameEvent);
        }
        return $game;
    }

    /**
     * @param $table_id
     * @param $team
     * @param $player
     * @param $user
     * @return Game
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
     * @return Game
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
        $game = $this->checkGame($game, $team, $action_time);

        $em->flush($game);
        return $game;
    }

    /**
     * @param $game Game|Match
     * @param $winner_side
     * @param $action_time
     * @return Game
     */
    private function checkGame($game, $winner_side, $action_time)
    {
        if ($game->getGoals($winner_side) == 10)
        {
            $game->setEndTime($action_time);

            $gameEvent = new GameStatusEvent();
            if (is_a($game, 'Liuks\GameBundle\Entity\Match'))
            {
                $this->container->get('tournament_utils.service')->resolveTournament($game, $winner_side, $action_time);
                $gameEvent->setTable($game->getTournament()->getTable());
            }
            else
            {
                $this->container->get('users_util.service')->resolveGameUsers($game, $winner_side);
                $gameEvent->setTable($game->getTable());
            }
            $this->container->get('event_dispatcher')->dispatch($gameEvent::GAMEOVER, $gameEvent);
        }
        return $game;
    }
}