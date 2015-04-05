<?php

namespace Liuks\TableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservations
 *
 * @ORM\Table(name="reservations", indexes={@ORM\Index(name="table_id", columns={"table_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Reservations
{
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
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

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
     * Set startTime
     *
     * @param integer $startTime
     * @return Reservations
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
     * @return Reservations
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
     * Set user
     *
     * @param \Liuks\UserBundle\Entity\Users $user
     * @return Reservations
     */
    public function setUser(\Liuks\UserBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Liuks\UserBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set table
     *
     * @param \Liuks\TableBundle\Entity\Table $table
     * @return Reservations
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
}
