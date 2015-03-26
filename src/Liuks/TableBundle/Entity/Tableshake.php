<?php

namespace Liuks\TableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tableshake
 *
 * @ORM\Table(name="tableShake", indexes={@ORM\Index(name="table_id", columns={"table_id"})})
 * @ORM\Entity
 */
class Tableshake
{
    /**
     * @var integer
     *
     * @ORM\Column(name="last_shake", type="integer", nullable=false)
     */
    private $lastShake;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Liuks\TableBundle\Entity\Tables
     *
     * @ORM\ManyToOne(targetEntity="Liuks\TableBundle\Entity\Tables")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="table_id", referencedColumnName="id")
     * })
     */
    private $table;



    /**
     * Set lastShake
     *
     * @param integer $lastShake
     * @return Tableshake
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set table
     *
     * @param \Liuks\TableBundle\Entity\Tables $table
     * @return Tableshake
     */
    public function setTable(\Liuks\TableBundle\Entity\Tables $table = null)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return \Liuks\TableBundle\Entity\Tables
     */
    public function getTable()
    {
        return $this->table;
    }
}
