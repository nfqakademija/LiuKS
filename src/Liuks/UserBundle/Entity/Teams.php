<?php

namespace Liuks\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teams
 *
 * @ORM\Table(name="teams", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="captain_id", columns={"captain_id"}), @ORM\Index(name="player_id", columns={"player_id"})})
 * @ORM\Entity
 */
class Teams
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="games_won", type="integer", nullable=false)
     */
    private $gamesWon;

    /**
     * @var integer
     *
     * @ORM\Column(name="games_played", type="integer", nullable=false)
     */
    private $gamesPlayed;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_goals", type="integer", nullable=false)
     */
    private $totalGoals;

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
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * })
     */
    private $player;

    /**
     * @var \Liuks\UserBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="captain_id", referencedColumnName="id")
     * })
     */
    private $captain;



    /**
     * Set name
     *
     * @param string $name
     * @return Teams
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set gamesWon
     *
     * @param integer $gamesWon
     * @return Teams
     */
    public function setGamesWon($gamesWon)
    {
        $this->gamesWon = $gamesWon;

        return $this;
    }

    /**
     * Get gamesWon
     *
     * @return integer 
     */
    public function getGamesWon()
    {
        return $this->gamesWon;
    }

    /**
     * Set gamesPlayed
     *
     * @param integer $gamesPlayed
     * @return Teams
     */
    public function setGamesPlayed($gamesPlayed)
    {
        $this->gamesPlayed = $gamesPlayed;

        return $this;
    }

    /**
     * Get gamesPlayed
     *
     * @return integer 
     */
    public function getGamesPlayed()
    {
        return $this->gamesPlayed;
    }

    /**
     * Set totalGoals
     *
     * @param integer $totalGoals
     * @return Teams
     */
    public function setTotalGoals($totalGoals)
    {
        $this->totalGoals = $totalGoals;

        return $this;
    }

    /**
     * Get totalGoals
     *
     * @return integer 
     */
    public function getTotalGoals()
    {
        return $this->totalGoals;
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
     * Set player
     *
     * @param \Liuks\UserBundle\Entity\Users $player
     * @return Teams
     */
    public function setPlayer(\Liuks\UserBundle\Entity\Users $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \Liuks\UserBundle\Entity\Users
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set captain
     *
     * @param \Liuks\UserBundle\Entity\Users $captain
     * @return Teams
     */
    public function setCaptain(\Liuks\UserBundle\Entity\Users $captain = null)
    {
        $this->captain = $captain;

        return $this;
    }

    /**
     * Get captain
     *
     * @return \Liuks\UserBundle\Entity\Users
     */
    public function getCaptain()
    {
        return $this->captain;
    }
}
