<?php
namespace Liuks\TableBundle\Events;

use Symfony\Component\EventDispatcher\Event;

class TableCreationEvent extends Event
{
    const TABLECREATED = 'table_created_successfully';

    /**
     * @var \Liuks\TableBundle\Entity\Tables
     */
    private $table;

    /**
     * @return \Liuks\TableBundle\Entity\Tables
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param \Liuks\TableBundle\Entity\Tables $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }


}