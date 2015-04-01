<?php

namespace Liuks\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
    public function indexAction()
    {
        return $this->render('.html.twig');
    }
}