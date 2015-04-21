<?php

namespace Liuks\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="games", indexes={@ORM\Index(name="table_id", columns={"table_id"}), @ORM\Index(name="user1", columns={"user1"}), @ORM\Index(name="user2", columns={"user2"}), @ORM\Index(name="user3", columns={"user3"}), @ORM\Index(name="user4", columns={"user4"}), @ORM\Index(name="team1", columns={"team1"}), @ORM\Index(name="team2", columns={"team2"})})
 * @ORM\Entity
 */
class Game
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
     * @ORM\Column(name="goals1", type="integer")
     */
    private $goals1;

    /**
     * @var integer
     *
     * @ORM\Column(name="goals2", type="integer")
     */
    private $goals2;

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
     * @var \Liuks\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user1", referencedColumnName="id")
     * })
     */
    private $user1;

    /**
     * @var \Liuks\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user2", referencedColumnName="id")
     * })
     */
    private $user2;

    /**
     * @var \Liuks\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user3", referencedColumnName="id")
     * })
     */
    private $user3;

    /**
     * @var \Liuks\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user4", referencedColumnName="id")
     * })
     */
    private $user4;

    /**
     * @var \Liuks\UserBundle\Entity\Team
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Team")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="team1", referencedColumnName="id")
     * })
     */
    private $team1;

    /**
     * @var \Liuks\UserBundle\Entity\Team
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Team")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="team2", referencedColumnName="id")
     * })
     */
    private $team2;

    /**
     * @var \Liuks\TableBundle\Entity\Table
     *
     * @ORM\ManyToOne(targetEntity="Liuks\TableBundle\Entity\Table")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="table_id", referencedColumnName="id")
     * })
     */
    private $table;

    /**
     * Set goals based on team
     *
     * @param integer $goals
     * @param integer $team
     * @return Game
     */
    public function setGoals($goals, $team)
    {
        switch ($team)
        {
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
        switch ($team)
        {
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
     * Set startTime
     *
     * @param integer $startTime
     * @return Game
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
     * @return Game
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
     * @param \Liuks\UserBundle\Entity\User $user3
     * @return Game
     */
    public function setUser3(\Liuks\UserBundle\Entity\User $user3 = null)
    {
        $this->user3 = $user3;

        return $this;
    }

    /**
     * Get user3
     *
     * @return \Liuks\UserBundle\Entity\User
     */
    public function getUser3()
    {
        return $this->user3;
    }

    /**
     * Set user4
     *
     * @param \Liuks\UserBundle\Entity\User $user4
     * @return Game
     */
    public function setUser4(\Liuks\UserBundle\Entity\User $user4 = null)
    {
        $this->user4 = $user4;

        return $this;
    }

    /**
     * Get user4
     *
     * @return \Liuks\UserBundle\Entity\User
     */
    public function getUser4()
    {
        return $this->user4;
    }

    /**
     * Set user2
     *
     * @param \Liuks\UserBundle\Entity\User $user2
     * @return Game
     */
    public function setUser2(\Liuks\UserBundle\Entity\User $user2 = null)
    {
        $this->user2 = $user2;

        return $this;
    }

    /**
     * Get user2
     *
     * @return \Liuks\UserBundle\Entity\User
     */
    public function getUser2()
    {
        return $this->user2;
    }

    /**
     * Set user1
     *
     * @param \Liuks\UserBundle\Entity\User $user1
     * @return Game
     */
    public function setUser1(\Liuks\UserBundle\Entity\User $user1 = null)
    {
        $this->user1 = $user1;

        return $this;
    }

    /**
     * Get user1
     *
     * @return \Liuks\UserBundle\Entity\User
     */
    public function getUser1()
    {
        return $this->user1;
    }

    /**
     * Set team1
     *
     * @param \Liuks\UserBundle\Entity\Team $team1
     * @return Game
     */
    public function setTeam1(\Liuks\UserBundle\Entity\Team $team1 = null)
    {
        $this->team1 = $team1;

        return $this;
    }

    /**
     * Get team1
     *
     * @return \Liuks\UserBundle\Entity\Team
     */
    public function getTeam1()
    {
        return $this->team1;
    }

    /**
     * Set team2
     *
     * @param \Liuks\UserBundle\Entity\Team $team2
     * @return Game
     */
    public function setTeam2(\Liuks\UserBundle\Entity\Team $team2 = null)
    {
        $this->team2 = $team2;

        return $this;
    }

    /**
     * Get team2
     *
     * @return \Liuks\UserBundle\Entity\Team
     */
    public function getTeam2()
    {
        return $this->team2;
    }

    /**
     * Set table
     *
     * @param \Liuks\TableBundle\Entity\Table $table
     * @return Game
     */
    public function setTable(\Liuks\TableBundle\Entity\Table $table = null)
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

    /**
     * Set user based on given position
     *
     * @param \Liuks\UserBundle\Entity\User $user
     * @param integer $position
     * @return Game
     */
    public function setUser(\Liuks\UserBundle\Entity\User $user, $position)
    {

        switch ($position)
        {
            case 0:
                $this->user1 = $user;
                break;
            case 1:
                $this->user2 = $user;
                break;
            case 2:
                $this->user3 = $user;
                break;
            case 3:
                $this->user4 = $user;
                break;
            default:
                //error
        }

        return $this;
    }

    /**
     * Get user based on position
     *
     * @param integer $position
     * @return \Liuks\UserBundle\Entity\User
     */
    public function getUser($position)
    {
        switch ($position)
        {
            case 0:
                return $this->user1;
            case 1:
                return $this->user2;
            case 2:
                return $this->user3;
            case 3:
                return $this->user4;
            default:
                //throw error
        }
        return null;
    }

    /**
     * Set goals1
     *
     * @param integer $goals1
     * @return Game
     */
    public function setGoals1($goals1)
    {
        $this->goals1 = $goals1;

        return $this;
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
     * Set goals2
     *
     * @param integer $goals2
     * @return Game
     */
    public function setGoals2($goals2)
    {
        $this->goals2 = $goals2;

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
}
