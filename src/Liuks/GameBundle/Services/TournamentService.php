<?php

namespace Liuks\GameBundle\Services;

use Liuks\GameBundle\Entity\Competitor;
use Liuks\GameBundle\Entity\Match;
use Liuks\GameBundle\Entity\Tournament;
use Liuks\UserBundle\Entity\Team;
use Liuks\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAware;

class TournamentService extends ContainerAware
{
    /**
     * @param Tournament $tournament
     * @param User $user
     * @return bool
     */
    public function isCompetitor($tournament, $user)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $competitors = $em->createQuery(
            'SELECT c FROM LiuksGameBundle:Competitor c
            JOIN c.team team
            WHERE c.tournament = :t AND (team.captain = :user OR team.player = :user)'
        )->setParameter('t', $tournament)->setParameter('user', $user)->getResult();
        if ($competitors)
        {
            return true;
        }
        return false;
    }

    /**
     * @param Tournament $tournament
     * @return \stdClass object that contains teams and results arrays.
     */
    public function getTournamentData($tournament)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $teams = [];
        $results = [];
        if ($tournament)
        {
            $competitors = $em->getRepository('LiuksGameBundle:Competitor')->findBy(['tournament' => $tournament]);
            if ($competitors)
            {
                foreach($competitors as $competitor)
                {
                    if (!isset($teams[$competitor->getMatchup()]))
                    {
                        $count = count($teams);
                        $teams = array_merge($teams, array_fill((int)$competitor->getMatchup(), $count == 0 ? 1 : $count, ['', '']));
                    }

                    if ($teams[$competitor->getMatchup()][0] == '')
                    {
                        $teams[$competitor->getMatchup()][0] = $competitor->getTeam()->getName();
                    }
                    else
                    {
                        $teams[$competitor->getMatchup()][1] = $competitor->getTeam()->getName();
                    }
                }
            }

            $matches = $em->createQuery(
                'SELECT m FROM LiuksGameBundle:Match m
                 WHERE m.tournament = :t AND m.endTime != :time
                 ORDER BY m.round'
            )->setParameter('t', $tournament)->setParameter('time', 0)->getResult();
            if ($matches)
            {
                foreach($matches as $match)
                {
                    /** @var $match Match */
                    $results[$match->getRound()][$match->getMatchup()] = [$match->getGoals1(), $match->getGoals2()];
                }
            }
        }

        $data = new \stdClass();
        $data->teams = $teams;
        $data->results = $results;

        return $data;
    }

    /**
     * @param Tournament $tournament
     * @param Team $team
     * @return Competitor
     */
    public function addCompetitor($tournament, $team)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $position = floor($tournament->getCompetitors()/2);
        $competitor = new Competitor();
        $competitor->setRound(0);
        $competitor->setMatchup($position);
        $competitor->setTournament($tournament);
        $competitor->setTeam($team);
        $em->persist($competitor);
        $em->flush($competitor);

        $tournament->setCompetitors($tournament->getCompetitors()+1);
        $em->flush($tournament);

        return $competitor;
    }
}