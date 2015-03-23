<?php

namespace Liuks\TableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TournamentController extends Controller
{
    public function indexAction()
    {
        return $this->render('.html.twig');
    }
}