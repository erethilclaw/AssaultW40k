<?php

namespace ArmyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ArmyDataBundle:Default:index.html.twig');
    }
}
