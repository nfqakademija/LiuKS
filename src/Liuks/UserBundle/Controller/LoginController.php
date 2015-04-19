<?php

namespace Liuks\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    public function loginAction()
    {
        return $this->render('LiuksUserBundle::login.html.twig');
    }
}