<?php

namespace Liuks\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @ORM\Table(name="groups", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="owner", columns={"owner"})})
 * @ORM\Entity
 */
class Group
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
     * @var \Liuks\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner", referencedColumnName="id")
     * })
     */
    private $owner;



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
     * @return Group
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
     * Set owner
     *
     * @param \Liuks\UserBundle\Entity\User $owner
     * @return Group
     */
    public function setOwner(\Liuks\UserBundle\Entity\User $owner = null)
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
}
