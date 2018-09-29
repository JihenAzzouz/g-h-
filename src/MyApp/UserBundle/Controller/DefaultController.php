<?php

namespace MyApp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyAppUserBundle::layout.html.twig');
    }
    public function testAction()
    {
        return $this->render('MyAppUserBundle:experience:test.htlm.twig');
    }
}
