<?php

namespace Liuks\TableBundle\EventListeners;

use Liuks\TableBundle\Events\TableCreationEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class TableCreationEventListener extends ContainerAware
{
    public function onTableCreate(TableCreationEvent $event)
    {
        //Announce that a new table is available in Your city...
    }
}