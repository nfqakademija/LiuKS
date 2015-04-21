<?php

namespace Liuks\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Match
 *
 * @ORM\Table(name="matches", indexes={@ORM\Index(name="table_id", columns={"table_id"}), @ORM\Index(name="tournament_id", columns={"tournament_id"}), @ORM\Index(name="competitor1", columns={"competitor1"}), @ORM\Index(name="competitor2", columns={"competitor2"})})
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
     * @var \Liuks\GameBundle\Entity\Tournament
     *
     * @ORM\ManyToOne(targetEntity="Liuks\GameBundle\Entity\Tournament")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tournament_id", referencedColumnName="id", nullable=false)
     * })
     */

    private $tournament;

    /**
     * @var \Liuks\TableBundle\Entity\Table
     *
     * @ORM\ManyToOne(targetEntity="Liuks\TableBundle\Entity\Table")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="table_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $table;

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
     * Get startTime
     *
     * @return integer 
     */
    public function getStartTime()
    {
        return $this->startTime;
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
     * Get endTime
     *
     * @return integer 
     */
    public function getEndTime()
    {
        return $this->endTime;
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
     * Get competitor1
     *
     * @return \Liuks\GameBundle\Entity\Competitor 
     */
    public function getCompetitor1()
    {
        return $this->competitor1;
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
     * Get competitor2
     *
     * @return \Liuks\GameBundle\Entity\Competitor 
     */
    public function getCompetitor2()
    {
        return $this->competitor2;
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
     * Set table
     *
     * @param \Liuks\TableBundle\Entity\Table $table
     * @return Match
     */
    public function setTable(\Liuks\TableBundle\Entity\Table $table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return \Liuks\TableBundle\Entity\Table 
     */
    public function getTable()
    {
        return $this->table;
    }
}
