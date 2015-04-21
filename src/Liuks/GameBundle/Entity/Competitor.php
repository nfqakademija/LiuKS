<?php

namespace Liuks\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competitor
 *
 * @ORM\Table(name="competitors", indexes={@ORM\Index(name="tournament_id", columns={"tournament_id"}), @ORM\Index(name="team_id", columns={"team_id"})})
 * @ORM\Entity
 */
class Competitor
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
     * @var integer
     *
     * @ORM\Column(name="round", type="smallint")
     */
    private $round;

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
     * @var \Liuks\UserBundle\Entity\Team
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Team")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="team_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $team;

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
     * Set round
     *
     * @param integer $round
     * @return Competitor
     */
    public function setRound($round)
    {
        $this->round = $round;

        return $this;
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
     * Set tournament
     *
     * @param \Liuks\GameBundle\Entity\Tournament $tournament
     * @return Competitor
     */
    public function setTournament(\Liuks\GameBundle\Entity\Tournament $tournament)
    {
        $this->tournament = $tournament;

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
     * Set team
     *
     * @param \Liuks\UserBundle\Entity\Team $team
     * @return Competitor
     */
    public function setTeam(\Liuks\UserBundle\Entity\Team $team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \Liuks\UserBundle\Entity\Team 
     */
    public function getTeam()
    {
        return $this->team;
    }
}
