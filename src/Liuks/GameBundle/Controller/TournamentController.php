<?php

namespace Liuks\GameBundle\Controller;

use Liuks\TableBundle\Entity\Table;
use Liuks\GameBundle\Entity\Tournament;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TournamentController extends Controller
{
    /**
     * Finds and displays an ongoing tournament data for specific table.
     *
     * @param integer $table_id
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function currentAction($table_id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $table = $em->getRepository('LiuksTableBundle:Table')->find($table_id);
        $tournament = $em->getRepository('LiuksGameBundle:Tournament')->findOneBy(['table' => $table, 'endTime' => 0]);
        $data = $this->get('tournament_utils.service')->getTournamentData($tournament);
        return $this->render('LiuksGameBundle:Tournament:show.html.twig',
            [
                'data' => $data,
                'tournament' => $tournament
            ]);
    }
}