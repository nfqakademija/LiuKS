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
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50)
     */
    private $city;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=7)
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=7)
     */
    private $long;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="available_from", type="time")
     */
    private $availableFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="available_to", type="time")
     */
    private $availableTo;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner", referencedColumnName="id", nullable=false)
     * })
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="api", type="string", length=100, nullable=true)
     */
    private $api;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean")
     */
    private $private;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_event_id", type="integer")
     */
    private $lastEventId;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_data_update", type="integer")
     */
    private $lastDataUpdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_shake", type="integer")
     */
    private $lastShake;

    /**
     * @var boolean
     *
     * @ORM\Column(name="free", type="boolean")
     */
    private $free;

    /**
     * @var boolean
     *
     * @ORM\Column(name="disabled", type="boolean")
     */
    private $disabled;

    /**
     * @var \Liuks\UserBundle\Entity\Group
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $group;

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
     * Set lat
     *
     * @param float $lat
     * @return Table
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set long
     *
     * @param float $long
     * @return Table
     */
    public function setLong($long)
    {
        $this->long = $long;

        return $this;
    }

    /**
     * Get long
     *
     * @return float
     */
    public function getLong()
    {
        return $this->long;
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
     * Set lastEventId
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
     * Get lastEventId
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
     * Set owner
     *
     * @param \Liuks\UserBundle\Entity\User $owner
     * @return Table
     */
    public function setOwner(\Liuks\UserBundle\Entity\User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Liuks\UserBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set group
     *
     * @param \Liuks\UserBundle\Entity\Group $group
     * @return Table
     */
    public function setGroup(\Liuks\UserBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Liuks\UserBundle\Entity\Group 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set lastDataUpdate
     *
     * @param integer $lastDataUpdate
     * @return Table
     */
    public function setLastDataUpdate($lastDataUpdate)
    {
        $this->lastDataUpdate = $lastDataUpdate;

        return $this;
    }

    /**
     * Get lastDataUpdate
     *
     * @return integer 
     */
    public function getLastDataUpdate()
    {
        return $this->lastDataUpdate;
    }
}
