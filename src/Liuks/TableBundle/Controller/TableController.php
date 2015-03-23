<?php

namespace Liuks\TableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TableController extends Controller
{
    public function indexAction()
    {
        return $this->render('.html.twig');
    }
}
