<?php

namespace Liuks\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Games
 *
 * @ORM\Table(name="games", indexes={@ORM\Index(name="table_id", columns={"table_id"}), @ORM\Index(name="user1", columns={"user1"}), @ORM\Index(name="user2", columns={"user2"}), @ORM\Index(name="user3", columns={"user3"}), @ORM\Index(name="user4", columns={"user4"}), @ORM\Index(name="team1", columns={"team1"}), @ORM\Index(name="team2", columns={"team2"})})
 * @ORM\Entity
 */
class Games
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="goals1", type="boolean", nullable=false)
     */
    private $goals1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="goals2", type="boolean", nullable=false)
     */
    private $goals2;

    /**
     * @var integer
     *
     * @ORM\Column(name="start_time", type="integer", nullable=false)
     */
    private $startTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="end_time", type="integer", nullable=false)
     */
    private $endTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Liuks\UserBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user3", referencedColumnName="id")
     * })
     */
    private $user3;

    /**
     * @var \Liuks\UserBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user4", referencedColumnName="id")
     * })
     */
    private $user4;

    /**
     * @var \Liuks\UserBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user2", referencedColumnName="id")
     * })
     */
    private $user2;

    /**
     * @var \Liuks\UserBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user1", referencedColumnName="id")
     * })
     */
    private $user1;

    /**
     * @var \Liuks\UserBundle\Entity\Teams
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="team1", referencedColumnName="id")
     * })
     */
    private $team1;

    /**
     * @var \Liuks\UserBundle\Entity\Teams
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="team2", referencedColumnName="id")
     * })
     */
    private $team2;

    /**
     * @var \Liuks\TableBundle\Entity\Tables
     *
     * @ORM\ManyToOne(targetEntity="Liuks\TableBundle\Entity\Tables")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="table_id", referencedColumnName="id")
     * })
     */
    private $table;



    /**
     * Set goals1
     *
     * @param boolean $goals1
     * @return Games
     */
    public function setGoals1($goals1)
    {
        $this->goals1 = $goals1;

        return $this;
    }

    /**
     * Get goals1
     *
     * @return boolean 
     */
    public function getGoals1()
    {
        return $this->goals1;
    }

    /**
     * Set goals2
     *
     * @param boolean $goals2
     * @return Games
     */
    public function setGoals2($goals2)
    {
        $this->goals2 = $goals2;

        return $this;
    }

    /**
     * Get goals2
     *
     * @return boolean 
     */
    public function getGoals2()
    {
        return $this->goals2;
    }

    /**
     * Set startTime
     *
     * @param integer $startTime
     * @return Games
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
     * @return Games
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user3
     *
     * @param \Liuks\UserBundle\Entity\Users $user3
     * @return Games
     */
    public function setUser3(\Liuks\UserBundle\Entity\Users $user3 = null)
    {
        $this->user3 = $user3;

        return $this;
    }

    /**
     * Get user3
     *
     * @return \Liuks\UserBundle\Entity\Users
     */
    public function getUser3()
    {
        return $this->user3;
    }

    /**
     * Set user4
     *
     * @param \Liuks\UserBundle\Entity\Users $user4
     * @return Games
     */
    public function setUser4(\Liuks\UserBundle\Entity\Users $user4 = null)
    {
        $this->user4 = $user4;

        return $this;
    }

    /**
     * Get user4
     *
     * @return \Liuks\UserBundle\Entity\Users
     */
    public function getUser4()
    {
        return $this->user4;
    }

    /**
     * Set user2
     *
     * @param \Liuks\UserBundle\Entity\Users $user2
     * @return Games
     */
    public function setUser2(\Liuks\UserBundle\Entity\Users $user2 = null)
    {
        $this->user2 = $user2;

        return $this;
    }

    /**
     * Get user2
     *
     * @return \Liuks\UserBundle\Entity\Users
     */
    public function getUser2()
    {
        return $this->user2;
    }

    /**
     * Set user1
     *
     * @param \Liuks\UserBundle\Entity\Users $user1
     * @return Games
     */
    public function setUser1(\Liuks\UserBundle\Entity\Users $user1 = null)
    {
        $this->user1 = $user1;

        return $this;
    }

    /**
     * Get user1
     *
     * @return \Liuks\UserBundle\Entity\Users
     */
    public function getUser1()
    {
        return $this->user1;
    }

    /**
     * Set team1
     *
     * @param \Liuks\UserBundle\Entity\Teams $team1
     * @return Games
     */
    public function setTeam1(\Liuks\UserBundle\Entity\Teams $team1 = null)
    {
        $this->team1 = $team1;

        return $this;
    }

    /**
     * Get team1
     *
     * @return \Liuks\UserBundle\Entity\Teams
     */
    public function getTeam1()
    {
        return $this->team1;
    }

    /**
     * Set team2
     *
     * @param \Liuks\UserBundle\Entity\Teams $team2
     * @return Games
     */
    public function setTeam2(\Liuks\UserBundle\Entity\Teams $team2 = null)
    {
        $this->team2 = $team2;

        return $this;
    }

    /**
     * Get team2
     *
     * @return \Liuks\UserBundle\Entity\Teams
     */
    public function getTeam2()
    {
        return $this->team2;
    }

    /**
     * Set table
     *
     * @param \Liuks\TableBundle\Entity\Tables $table
     * @return Games
     */
    public function setTable(\Liuks\TableBundle\Entity\Tables $table = null)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return \Liuks\TableBundle\Entity\Tables
     */
    public function getTable()
    {
        return $this->table;
    }
}
