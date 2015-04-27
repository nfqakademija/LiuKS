<?php

namespace Liuks\UserBundle\Services;


use Liuks\UserBundle\Entity\Team;
use Liuks\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAware;

class UserService extends ContainerAware
{
    /**
     * @param User $captain
     * @return Team
     */
    public function createTeam($captain)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $team = new Team();
        $team->setName('');
        $team->setCaptain($captain);
        $team->setTotalGoals(0);
        $team->setGamesWon(0);
        $team->setGamesPlayed(0);
        $em->persist($team);
        $em->flush($team);
        return $team;
    }

    /**
     * @param integer $team_id
     * @param User $user
     * @return Team|null
     */
    public function addTeamMember($team_id, $user)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $team = $em->getRepository('LiuksUserBundle:Team')->find($team_id);
        if (!$team->getPlayer())
        {
            $team->setPlayer($user);
            $em->flush($team);
            return $team;
        }
        return null;
    }
}