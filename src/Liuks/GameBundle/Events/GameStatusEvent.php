<?php

namespace Liuks\GameBundle\Events;

use Symfony\Component\EventDispatcher\Event;

class GameStatusEvent extends Event
{
    const GAMECREATED = 'game_created_event';
    const GAMEOVER = 'game_over_event';

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