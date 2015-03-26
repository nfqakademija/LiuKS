<?php

namespace Liuks\TableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tableupdate
 *
 * @ORM\Table(name="tableUpdate", indexes={@ORM\Index(name="index2", columns={"table_id"})})
 * @ORM\Entity
 */
class Tableupdate
{
    /**
     * @var integer
     *
     * @ORM\Column(name="last_update", type="integer", nullable=false)
     */
    private $lastUpdate;

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
     * Set lastUpdate
     *
     * @param integer $lastUpdate
     * @return Tableupdate
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return integer 
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
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
     * @return Tableupdate
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
