<?php

namespace Liuks\GameBundle\EventListeners;


use Liuks\GameBundle\Events\GameStatusEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class GameStatusEventListener extends ContainerAware
{
    public function onGameCreate(GameStatusEvent $event)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $table = $event->getTable();
        $table->setFree(false);
        $em->flush($table);
    }

    public function onGameOver(GameStatusEvent $event)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $table = $event->getTable();
        $table->setFree(true);
        $table->setLastShake(0);
        $em->flush($table);
    }
}