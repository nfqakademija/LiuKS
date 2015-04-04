<?php

namespace Liuks\GameBundle\Events;

use Symfony\Component\EventDispatcher\Event;

class GameStatusEvent extends Event
{
    const GAMECREATED = 'game_created_event';
    const GAMEOVER = 'game_over_event';

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