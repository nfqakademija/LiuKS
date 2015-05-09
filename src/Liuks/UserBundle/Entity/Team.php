<?php

namespace Liuks\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Table(name="teams", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="captain_id", columns={"captain_id"}), @ORM\Index(name="player_id", columns={"player_id"})})
 * @ORM\Entity
 */
class Team
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var \Liuks\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * })
     */
    private $player;

    /**
     * @var \Liuks\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="captain_id", referencedColumnName="id")
     * })
     */
    private $captain;

    /**
     * @var integer
     *
     * @ORM\Column(name="games_won", type="integer")
     */
    private $gamesWon;

    /**
     * @var integer
     *
     * @ORM\Column(name="games_played", type="integer")
     */
    private $gamesPlayed;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_goals", type="integer")
     */
    private $totalGoals;

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set gamesWon
     *
     * @param integer $gamesWon
     * @return Team
     */
    public function setGamesWon($gamesWon)
    {
        $this->gamesWon = $gamesWon;

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
     * Set gamesPlayed
     *
     * @param integer $gamesPlayed
     * @return Team
     */
    public function setGamesPlayed($gamesPlayed)
    {
        $this->gamesPlayed = $gamesPlayed;

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
     * Set totalGoals
     *
     * @param integer $totalGoals
     * @return Team
     */
    public function setTotalGoals($totalGoals)
    {
        $this->totalGoals = $totalGoals;

        return $this;
    }

    /**
     * Get player
     *
     * @return \Liuks\UserBundle\Entity\User
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set player
     *
     * @param \Liuks\UserBundle\Entity\User $player
     * @return Team
     */
    public function setPlayer(\Liuks\UserBundle\Entity\User $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get captain
     *
     * @return \Liuks\UserBundle\Entity\User
     */
    public function getCaptain()
    {
        return $this->captain;
    }

    /**
     * Set captain
     *
     * @param \Liuks\UserBundle\Entity\User $captain
     * @return Team
     */
    public function setCaptain(\Liuks\UserBundle\Entity\User $captain = null)
    {
        $this->captain = $captain;

        return $this;
    }
}
