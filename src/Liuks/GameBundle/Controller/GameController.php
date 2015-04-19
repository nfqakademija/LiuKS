<?php

namespace Liuks\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    public function indexAction()
    {
        return $this->render('LiuksGameBundle::home.html.twig');
    }
}