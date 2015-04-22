<?php

namespace Liuks\GameBundle\Services;

use Liuks\GameBundle\Entity\Match;
use Liuks\GameBundle\Entity\Tournament;
use Symfony\Component\DependencyInjection\ContainerAware;

class TournamentService extends ContainerAware
{
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
                        $teams[(int)$competitor->getMatchup()] = ['', ''];
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
}