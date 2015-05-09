<?php

namespace Liuks\TableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservations", indexes={@ORM\Index(name="table_id", columns={"table_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Reservation
{
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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Liuks\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\User")
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
     * @return Reservations
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
     * @return Reservation
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
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
     * Get user
     *
     * @return \Liuks\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param \Liuks\UserBundle\Entity\User $user
     * @return Reservation
     */
    public function setUser(\Liuks\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

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
     * Set table
     *
     * @param \Liuks\TableBundle\Entity\Table $table
     * @return Reservation
     */
    public function setTable(\Liuks\TableBundle\Entity\Table $table = null)
    {
        $this->table = $table;

        return $this;
    }
}
