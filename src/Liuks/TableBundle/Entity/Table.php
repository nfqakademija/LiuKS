<?php

namespace Liuks\TableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table
 *
 * @ORM\Table(name="tables", indexes={@ORM\Index(name="group_id", columns={"group_id"})})
 * @ORM\Entity
 */
class Table
{
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=false)
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="available_from", type="time", nullable=false)
     */
    private $availableFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="available_to", type="time", nullable=false)
     */
    private $availableTo;

    /**
     * @var string
     *
     * @ORM\Column(name="api", type="string", length=100, nullable=false)
     */
    private $api;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean", nullable=false)
     */
    private $private;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_event_id", type="integer", nullable=false)
     */
    private $lastEventId;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_shake", type="integer", nullable=false)
     */
    private $lastShake;

    /**
     * @var boolean
     *
     * @ORM\Column(name="free", type="boolean", nullable=false)
     */
    private $free;

    /**
     * @var boolean
     *
     * @ORM\Column(name="disabled", type="boolean", nullable=false)
     */
    private $disabled;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Liuks\UserBundle\Entity\Groups
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * })
     */
    private $group;



    /**
     * Set address
     *
     * @param string $address
     * @return Table
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Table
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set availableFrom
     *
     * @param \DateTime $availableFrom
     * @return Table
     */
    public function setAvailableFrom($availableFrom)
    {
        $this->availableFrom = $availableFrom;

        return $this;
    }

    /**
     * Get availableFrom
     *
     * @return \DateTime 
     */
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    /**
     * Set availableTo
     *
     * @param \DateTime $availableTo
     * @return Table
     */
    public function setAvailableTo($availableTo)
    {
        $this->availableTo = $availableTo;

        return $this;
    }

    /**
     * Get availableTo
     *
     * @return \DateTime 
     */
    public function getAvailableTo()
    {
        return $this->availableTo;
    }

    /**
     * Set api
     *
     * @param string $api
     * @return Table
     */
    public function setApi($api)
    {
        $this->api = $api;

        return $this;
    }

    /**
     * Get api
     *
     * @return string
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Set private
     *
     * @param boolean $private
     * @return Table
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return boolean 
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set lastId
     *
     * @param integer $lastEventId
     * @return Table
     */
    public function setLastEventId($lastEventId)
    {
        $this->lastEventId = $lastEventId;

        return $this;
    }

    /**
     * Get lastId
     *
     * @return integer
     */
    public function getLastEventId()
    {
        return $this->lastEventId;
    }

    /**
     * Set lastShake
     *
     * @param integer $lastShake
     * @return Table
     */
    public function setLastShake($lastShake)
    {
        $this->lastShake = $lastShake;

        return $this;
    }

    /**
     * Get lastShake
     *
     * @return integer
     */
    public function getLastShake()
    {
        return $this->lastShake;
    }

    /**
     * Set free
     *
     * @param boolean $free
     * @return Table
     */
    public function setFree($free)
    {
        $this->free = $free;

        return $this;
    }

    /**
     * Get free
     *
     * @return boolean
     */
    public function getFree()
    {
        return $this->free;
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     * @return Table
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled()
    {
        return $this->disabled;
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
     * Set group
     *
     * @param \Liuks\UserBundle\Entity\Groups $group
     * @return Table
     */
    public function setGroup(\Liuks\UserBundle\Entity\Groups $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Liuks\UserBundle\Entity\Groups
     */
    public function getGroup()
    {
        return $this->group;
    }
}