<?php
namespace Liuks\TableBundle\Events;

use Symfony\Component\EventDispatcher\Event;

class TableCreationEvent extends Event
{
    const TABLECREATED = 'table_created_successfully';

    /**
     * @var \Liuks\TableBundle\Entity\Table
     */
    private $table;

    /**
     * @return \Liuks\TableBundle\Entity\Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param \Liuks\TableBundle\Entity\Table $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }


}