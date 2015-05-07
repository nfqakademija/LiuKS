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
        if ($competitors) {
            return true;
        }

        return false;
    }

    public function updateTournamentResultsFromJson($tournament_id, $json)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $tournament = $em->getRepository('LiuksGameBundle:Tournament')->find($tournament_id);
        $matches = $em->getRepository('LiuksGameBundle:Match')->findBy(
            ['tournament' => $tournament],
            ['round' => 'ASC', 'matchup' => 'ASC']
        );
        $data = json_decode($json)[0];
        foreach ($matches as $match) {
            $res = $data[$match->getRound()][$match->getMatchup()];
            $match->setGoals1(array_key_exists(0, $res) ? $res[0] : $match->getGoals1());
            $match->setGoals2(array_key_exists(1, $res) ? $res[1] : $match->getGoals2());
            $this->resolveTournament($match, $match->getGoals1() < $match->getGoals2(), time());
            unset($data[$match->getRound()][$match->getMatchup()]);
        }
        $newMatches = [];
        foreach ($data as $r => $round) {
            foreach ($round as $m => $results) {
                $newMatches[] = $this->newMatch($tournament, $r, $m, $results);
            }
        }
        $em->flush(array_merge($matches, $newMatches));

        return true;
    }

    /**
     * @param Match $match
     * @param $winner_side
     * @param $action_time
     */
    public function resolveTournament($match, $winner_side, $action_time)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $winner = $match->getCompetitor($winner_side);
        $tournament = $match->getTournament();
        if ($tournament->getCurrentRound() == -1) {
            $tournament->setEndTime($action_time);
        } else {
            $last_matchup = (int)(($tournament->getCompetitors() - 1) / 2);
            if ($tournament->getCurrentRound() != 0) {
                $last_matchup = (int)($last_matchup / ($tournament->getCurrentRound() * 2));
            }
            if ($last_matchup == 0) {
                $tournament->setCurrentRound(-1);

                $looser = $match->getCompetitor(!$winner_side);
                $looser->setRound($looser->getRound() + 1);
                $looser->setMatchup(1);
                $em->flush($looser);
            } elseif ($winner->getMatchup() == $last_matchup) {
                $tournament->setCurrentRound($tournament->getCurrentRound() + 1);
            }
            $winner->setRound($winner->getRound() + 1);
            $winner->setMatchup(floor($winner->getMatchup() / 2));
            $em->flush($winner);
        }
        $em->flush($tournament);

        $users_util = $this->container->get('users_util.service');
        $users_util->addToTeamRanking($winner->getTeam(), true, $match->getGoals($winner_side));
        $users_util->addToTeamRanking(
            $match->getCompetitor(!$winner_side)->getTeam(),
            false,
            $match->getGoals(!$winner_side)
        );
    }

    /**
     * Returns a persisted but not flushed match based on arguments values.
     *
     * @param Tournament $tournament
     * @param integer $round
     * @param integer $matchup
     * @param array $results
     * @return Match
     */
    private function newMatch($tournament, $round, $matchup, $results)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $match = new Match();
        $match->setTournament($tournament);
        $match->setRound($round);
        $match->setMatchup($matchup);
        $match->setStartTime(time() - 60);
        $match->setEndTime(time());
        $goals = [0, 0];
        if (array_key_exists(0, $results)) {
            $goals[0] = $results[0];
        }
        if (array_key_exists(1, $results)) {
            $goals[1] = $results[1];
        }
        $match->setGoals1($goals[0]);
        $match->setGoals2($goals[1]);

        $firstPos = pow(2, $round);
        $lastPos = $matchup * $firstPos + $firstPos - 1;
        $firstPos *= $matchup;
        $lastRound = log($tournament->getCompetitors(), 2) - 1;
        if ($round == $lastRound) {
            //finals
            $lastMatchup = floor($tournament->getCompetitors() / 2) - 1;
            $competitors = $em->createQuery(
                'SELECT c FROM LiuksGameBundle:Competitor c
                WHERE c.tournament = :t AND c.round = :r AND c.matchup = :m'
            )->setParameter('t', $tournament)
                ->setParameter('r', $round)
                ->setParameter('m', 0);
            if ($lastPos > $lastMatchup) {
                //for third place
                $competitors = $competitors->setParameter('m', 1);
            }
            $competitors = $competitors->getResult();
        } else {
            $competitors = $em->createQuery(
                'SELECT c FROM LiuksGameBundle:Competitor c
                        WHERE c.tournament = :t AND c.startPos >= :fp AND c.startPos <= :lp AND c.round >= :cr'
            )->setParameter('t', $tournament)
                ->setParameter('fp', $firstPos)
                ->setParameter('lp', $lastPos)
                ->setParameter('cr', $round)
                ->getResult();
        }
        if ($competitors) {
            if (array_key_exists(0, $competitors)) {
                $match->setCompetitor1($competitors[0]);
            }
            if (array_key_exists(1, $competitors)) {
                $match->setCompetitor2($competitors[1]);
            }
        }
        $em->persist($match);

        return $match;
    }

    public function updateTournamentTeamsFromJson($tournament_id, $json)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $em->getRepository('LiuksGameBundle:Tournament')->find($tournament_id);
        //TODO: update teams based on teams json
        return false;
    }

    /**
     * @param Tournament $tournament
     * @return \stdClass object that contains teams and results arrays.
     */
    public function getTournamentData($tournament)
    {
        $teams = [];
        $results = [];
        if ($tournament) {
            $teams = $this->getTeams($tournament);
            $results = $this->getResults($tournament);
        }

        $data = new \stdClass();
        $data->teams = $teams;
        $data->results = $results;

        return $data;
    }

    /**
     * @param Tournament $tournament
     * @return array
     */
    private function getTeams($tournament)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $competitors = $em->getRepository('LiuksGameBundle:Competitor')->findBy(['tournament' => $tournament]);
        $teams = [];
        if ($competitors) {
            foreach ($competitors as $competitor) {
                if (!isset($teams[$competitor->getStartPos()])) {
                    $count = count($teams);
                    $teams = array_merge(
                        $teams,
                        array_fill((int)$competitor->getStartPos(), $count == 0 ? 1 : $count, ['', ''])
                    );
                }

                if ($teams[$competitor->getStartPos()][0] == '') {
                    $teams[$competitor->getStartPos()][0] = $competitor->getTeam()->getName();
                } else {
                    $teams[$competitor->getStartPos()][1] = $competitor->getTeam()->getName();
                }
            }
        }

        return $teams;
    }

    /**
     * @param Tournament $tournament
     * @return array
     */
    private function getResults($tournament)
    {
        $results = [];
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $matches = $em->createQuery(
            'SELECT m FROM LiuksGameBundle:Match m
                 WHERE m.tournament = :t AND m.endTime != :time
                 ORDER BY m.round'
        )->setParameter('t', $tournament)->setParameter('time', 0)->getResult();
        if ($matches) {
            foreach ($matches as $match) {
                /** @var Match $match */
                $results[0][$match->getRound()][$match->getMatchup()] = [$match->getGoals1(), $match->getGoals2()];
            }
        }

        return $results;
    }

    /**
     * @param Tournament $tournament
     * @param Team $team
     * @return Competitor
     */
    public function addCompetitor($tournament, $team)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $position = floor($tournament->getCompetitors() / 2);
        $competitor = new Competitor();
        $competitor->setRound(0);
        $competitor->setMatchup($position);
        $competitor->setStartPos($position);
        $competitor->setTournament($tournament);
        $competitor->setTeam($team);
        $em->persist($competitor);
        $em->flush($competitor);

        $tournament->setCompetitors($tournament->getCompetitors() + 1);
        $em->flush($tournament);

        return $competitor;
    }
}
