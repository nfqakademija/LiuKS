<?php

namespace Liuks\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersGroups
 *
 * @ORM\Table(name="users_groups", indexes={@ORM\Index(name="user_id", columns={"user_id"}), @ORM\Index(name="group_id", columns={"group_id"})})
 * @ORM\Entity
 */
class UsersGroups
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
     * @var \Liuks\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Liuks\UserBundle\Entity\Group
     *
     * @ORM\ManyToOne(targetEntity="Liuks\UserBundle\Entity\Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
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
     * Set user
     *
     * @param \Liuks\UserBundle\Entity\User $user
     * @return UsersGroups
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
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
     * Set group
     *
     * @param \Liuks\UserBundle\Entity\Group $group
     * @return UsersGroups
     */
    public function setGroup(Group $group = null)
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
}
