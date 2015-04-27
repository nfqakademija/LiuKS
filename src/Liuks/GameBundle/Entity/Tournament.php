<?php

namespace Liuks\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tournament
 *
 * @ORM\Table(name="tournaments", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="organizer_id", columns={"organizer_id"}), @ORM\Index(name="table_id", columns={"table_id"})})
 * @ORM\Entity
 */
class Tournament
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

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
     *   @ORM\JoinColumn(name="organizer_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $organizer;

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
     * @ORM\Column(name="competitors", type="integer")
     */
    private $competitors;

    /**
     * @var integer
     *
     * @ORM\Column(name="current_round", type="integer")
     */
    private $currentRound;

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
     * Set name
     *
     * @param string $name
     * @return Tournament
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
     * Set startTime
     *
     * @param integer $startTime
     * @return Tournament
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
     * @return Tournament
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
     * Set organizer
     *
     * @param \Liuks\UserBundle\Entity\User $organizer
     * @return Tournament
     */
    public function setOrganizer(\Liuks\UserBundle\Entity\User $organizer)
    {
        $this->organizer = $organizer;

        return $this;
    }

    /**
     * Get organizer
     *
     * @return \Liuks\UserBundle\Entity\User 
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    /**
     * Set table
     *
     * @param \Liuks\TableBundle\Entity\Table $table
     * @return Tournament
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

    /**
     * Set competitors
     *
     * @param integer $competitors
     * @return Tournament
     */
    public function setCompetitors($competitors)
    {
        $this->competitors = $competitors;

        return $this;
    }

    /**
     * Get competitors
     *
     * @return integer 
     */
    public function getCompetitors()
    {
        return $this->competitors;
    }

    /**
     * Set currentRound
     *
     * @param integer $currentRound
     * @return Tournament
     */
    public function setCurrentRound($currentRound)
    {
        $this->currentRound = $currentRound;

        return $this;
    }

    /**
     * Get currentRound
     *
     * @return integer 
     */
    public function getCurrentRound()
    {
        return $this->currentRound;
    }
}
