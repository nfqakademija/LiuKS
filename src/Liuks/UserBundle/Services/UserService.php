<?php

namespace Liuks\UserBundle\Services;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Liuks\GameBundle\Entity\Game;
use Liuks\UserBundle\Entity\Team;
use Liuks\UserBundle\Entity\User;

class UserService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     * @param User $captain
     * @param $team_name
     * @return Team
     * @throws EntityNotFoundException
     */
    public function createTeam($captain, $team_name)
    {
        if (!$captain)
        {
            throw new EntityNotFoundException();
        }
        $team = new Team();
        $team->setName($team_name);
        $team->setCaptain($captain);
        $team->setTotalGoals(0);
        $team->setGamesWon(0);
        $team->setGamesPlayed(0);
        $this->em->persist($team);
        $this->em->flush($team);
        return $team;
    }

    /**
     * @param integer $team_id
     * @param User $user
     * @return Team|null
     */
    public function addTeamMember($team_id, $user)
    {
        $team = $this->em->getRepository('LiuksUserBundle:Team')->find($team_id);
        if (!$team->getPlayer())
        {
            $team->setPlayer($user);
            $this->em->flush($team);
            return $team;
        }
        return null;
    }

    /**
     * @param Game $game
     * @param $winner_side
     */
    public function resolveGameUsers($game, $winner_side)
    {
        $uid = $winner_side*2;
        for ($i = 0; $i < 4; $i++)
        {
            $user = $game->getUser($i);
            $this->addToPlayerRanking($user, $uid == $i || $uid+1 == $i);
        }
        $this->addToTeamRanking($game->getTeam($winner_side), true, $game->getGoals($winner_side));
        $this->addToTeamRanking($game->getTeam(!$winner_side), false, $game->getGoals(!$winner_side));
    }

    /**
     * @param Team $team
     * @param bool $won
     * @param integer $goals
     */
    public function addToTeamRanking($team, $won, $goals)
    {
        if ($team)
        {
            if ($won)
            {
                $team->setGamesWon($team->getGamesWon() + 1);
            }
            $team->setGamesPlayed($team->getGamesPlayed() + 1);
            $team->setTotalGoals($team->getTotalGoals() + $goals);
            $this->em->flush($team);

            $this->addToPlayerRanking($team->getCaptain(), $won);
            $this->addToPlayerRanking($team->getPlayer(), $won);
        }
    }

    /**
     * @param User $player
     * @param bool $won
     */
    public function addToPlayerRanking($player, $won)
    {
        if ($player)
        {
            if ($won)
            {
                $player->setGamesWon($player->getGamesWon() + 1);
            }
            $player->setGamesPlayed($player->getGamesPlayed() + 1);
            $this->em->flush($player);
        }
    }
}