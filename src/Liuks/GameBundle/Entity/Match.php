<?php

namespace Liuks\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Match
 *
 * @ORM\Table(name="matches", indexes={@ORM\Index(name="tournament_id", columns={"tournament_id"}), @ORM\Index(name="competitor1", columns={"competitor1"}), @ORM\Index(name="competitor2", columns={"competitor2"})})
 * @ORM\Entity
 */
class Match
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Liuks\GameBundle\Entity\Competitor
     *
     * @ORM\ManyToOne(targetEntity="Liuks\GameBundle\Entity\Competitor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="competitor1", referencedColumnName="id")
     * })
     */
    private $competitor1;

    /**
     * @var \Liuks\GameBundle\Entity\Competitor
     *
     * @ORM\ManyToOne(targetEntity="Liuks\GameBundle\Entity\Competitor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="competitor2", referencedColumnName="id")
     * })
     */
    private $competitor2;

    /**
     * @var integer
     *
     * @ORM\Column(name="goals1", type="smallint")
     */
    private $goals1;

    /**
     * @var integer
     *
     * @ORM\Column(name="goals2", type="smallint")
     */
    private $goals2;

    /**
     * @var integer
     *
     * @ORM\Column(name="round", type="smallint")
     */
    private $round;

    /**
     * @var integer
     *
     * @ORM\Column(name="matchup", type="smallint")
     */
    private $matchup;

    /**
     * @var \Liuks\GameBundle\Entity\Tournament
     *
     * @ORM\ManyToOne(targetEntity="Liuks\GameBundle\Entity\Tournament")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tournament_id", referencedColumnName="id", nullable=false)
     * })
     */

    private $tournament;

    /**
     * @var integer
     *
     * @ORM\Column(name="start_time", type="integer")
     */
    private $startTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="end_time", type="integer")
     */
    private $endTime;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get goals1
     *
     * @return integer
     */
    public function getGoals1()
    {
        return $this->goals1;
    }

    /**
     * Set goals1
     *
     * @param integer $goals1
     * @return Match
     */
    public function setGoals1($goals1)
    {
        $this->goals1 = $goals1;

        return $this;
    }

    /**
     * Get goals2
     *
     * @return integer
     */
    public function getGoals2()
    {
        return $this->goals2;
    }

    /**
     * Set goals2
     *
     * @param integer $goals2
     * @return Match
     */
    public function setGoals2($goals2)
    {
        $this->goals2 = $goals2;

        return $this;
    }

    /**
     * Set goals based on team
     *
     * @param integer $goals
     * @param integer $team
     * @return Match
     */
    public function setGoals($goals, $team)
    {
        switch ($team) {
            case 0:
                $this->goals1 = $goals;
                break;
            case 1:
                $this->goals2 = $goals;
                break;
            default:
                //throw error
        }

        return $this;
    }

    /**
     * Get goals based on team
     *
     * @param integer $team
     * @return integer
     */
    public function getGoals($team)
    {
        switch ($team) {
            case 0:
                return $this->goals1;
                break;
            case 1:
                return $this->goals2;
                break;
            default:
                //throw error
        }

        return null;
    }

    /**
     * Get round
     *
     * @return integer
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Set round
     *
     * @param integer $round
     * @return Match
     */
    public function setRound($round)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get matchup
     *
     * @return integer
     */
    public function getMatchup()
    {
        return $this->matchup;
    }

    /**
     * Set matchup
     *
     * @param integer $matchup
     * @return Match
     */
    public function setMatchup($matchup)
    {
        $this->matchup = $matchup;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return integer
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set startTime
     *
     * @param integer $startTime
     * @return Match
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return integer
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set endTime
     *
     * @param integer $endTime
     * @return Match
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Set competitor based on num
     *
     * @param Competitor $competitor
     * @param $num
     * @return $this
     */
    public function setCompetitor(Competitor $competitor = null, $num)
    {
        switch ($num) {
            case 0:
                $this->competitor1 = $competitor;
                break;
            case 1:
                $this->competitor2 = $competitor;
                break;
            default:
                //throw error
        }

        return $this;
    }

    /**
     * Get competitor based on num
     *
     * @param $num
     * @return Competitor|null
     */
    public function getCompetitor($num)
    {
        switch ($num) {
            case 0:
                return $this->competitor1;
                break;
            case 1:
                return $this->competitor2;
                break;
            default:
                //throw error
        }

        return null;
    }

    /**
     * Get competitor1
     *
     * @return \Liuks\GameBundle\Entity\Competitor
     */
    public function getCompetitor1()
    {
        return $this->competitor1;
    }

    /**
     * Set competitor1
     *
     * @param \Liuks\GameBundle\Entity\Competitor $competitor1
     * @return Match
     */
    public function setCompetitor1(\Liuks\GameBundle\Entity\Competitor $competitor1 = null)
    {
        $this->competitor1 = $competitor1;

        return $this;
    }

    /**
     * Get competitor2
     *
     * @return \Liuks\GameBundle\Entity\Competitor
     */
    public function getCompetitor2()
    {
        return $this->competitor2;
    }

    /**
     * Set competitor2
     *
     * @param \Liuks\GameBundle\Entity\Competitor $competitor2
     * @return Match
     */
    public function setCompetitor2(\Liuks\GameBundle\Entity\Competitor $competitor2 = null)
    {
        $this->competitor2 = $competitor2;

        return $this;
    }

    /**
     * Get tournament
     *
     * @return \Liuks\GameBundle\Entity\Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * Set tournament
     *
     * @param \Liuks\GameBundle\Entity\Tournament $tournament
     * @return Match
     */
    public function setTournament(\Liuks\GameBundle\Entity\Tournament $tournament)
    {
        $this->tournament = $tournament;

        return $this;
    }
}
