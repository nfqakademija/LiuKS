<?php

namespace Liuks\TableBundle\EventListeners;

use Liuks\TableBundle\Entity\Tableshake;
use Liuks\TableBundle\Entity\Tableupdate;
use Liuks\TableBundle\Events\TableCreationEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class TableCreationEventListener extends ContainerAware
{
    public function onTableCreate(TableCreationEvent $event)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $table = $event->getTable();
        $update = new Tableupdate();
        $update->setTable($table);
        $update->setLastId(1);
        $em->persist($update);

        $shake = new Tableshake();
        $shake->setTable($table);
        $shake->setLastShake(0);
        $em->persist($shake);

        $em->flush([$shake, $update]);
    }
}