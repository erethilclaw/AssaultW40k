<?php

namespace ArmyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ArmyDataBundle\Entity\Unit;


class UnitController extends Controller
{
    public function indexAction()
    {
        $units = $this->getDoctrine()->getRepository('ArmyDataBundle:Unit')->findAll();
        return $this->render('ArmyDataBundle:Unit:index.html.twig',array('units' => $units));
    }
}
