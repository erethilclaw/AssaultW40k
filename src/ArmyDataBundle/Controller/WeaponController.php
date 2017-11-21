<?php

namespace ArmyDataBundle\Controller;

use ArmyDataBundle\Entity\Army;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use ArmyDataBundle\Entity\Weapon;

class WeaponController extends Controller
{
    public function indexAction()
    {
        $weapons = $this->getDoctrine()->getRepository('ArmyDataBundle:Weapon')->findAll();
        return $this->render('ArmyDataBundle:Weapon:index.html.twig', array('weapons' => $weapons));
    }

    public function addAction(Request $request)
    {
        $weapon = new Weapon();
        $form = $this->createForm('ArmyDataBundle\Form\WeaponType', $weapon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $units = $weapon->getUnits();
            $armies = $weapon->getArmies();
            $em = $this->getDoctrine()->getManager();
            foreach ($armies as $army) {
                $army->addWeapons($weapon);
                $em->persist($army);
                $em->flush($army);
            }
            foreach ($units as $unit) {
                $unit->addWeapons($weapon);
                $em->persist($unit);
                $em->flush($unit);
            }
            $em->persist($weapon);
            $em->flush($weapon);

            return $this->redirectToRoute('wp_index');
        }

        return $this->render('@ArmyData/Weapon/add_wp.html.twig', array(
            'weapon' => $weapon,
            'form' => $form->createView(),
        ));
    }

    public function showAction(Weapon $weapon)
    {
        $deleteForm = $this->createDeleteForm($weapon);

        return $this->render('ArmyDataBundle:Weapon:show_wp.html.twig', array(
            'weapon' => $weapon,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    private function createDeleteForm(Weapon $weapon)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wp_delete', array('id' => $weapon->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function editAction(Request $request, Weapon $weapon)
    {
        $deleteForm = $this->createDeleteForm($weapon);
        $editForm = $this->createForm('ArmyDataBundle\Form\WeaponType', $weapon);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $units = $weapon->getUnits();
            $armies = $weapon->getArmies();
            $em = $this->getDoctrine()->getManager();
            $armyList = $em->getRepository('ArmyDataBundle:Army')->findAll();
            foreach ($armies as $army) {
                $armyCollect = $em->getRepository('ArmyDataBundle:Army')->findCollect($army->getId());
                //         dump($armyCollect[0]->getWeapons());die();
                //             dump($armyCollect[0]->getWeapons()->contains($weapon));die();
                //        $armydb = $armyCollect[0];
                //      dump($armyCollect);die();
                foreach ($armyCollect as $armydb) {
                   //       dump($armydb->getWeapons()->contains($weapon));die();

                  //       dump($weapon->getArmies());die();
                    foreach ($armyList as $armySaved){
                 //       dump($armydb->getWeapons()->contains($weapon));die();
                        if ($armySaved->getWeapons()->contains($weapon) && !$armydb>getWeapons()->contains($weapon)) {
                             var_dump("entra eliminar");die();
                        }
                    }
//                    if (!$armydb->getWeapons()->contains($weapon) && $armyList>getWeapons()->contains($weapon)) {
//                        var_dump("entra eliminar");
//                        die();
//                        $armydb->removeWeapons($weapon);
//                        $weapon->removeArmies($armydb);
//                        $em->persist($armydb);
//                        $em->flush($armydb);
//                        $em->persist($weapon);
//                        $em->flush($weapon);
//                    }
                }
                $army->addWeapons($weapon);
                $em->persist($army);
                $em->flush($army);
            }
            foreach ($units as $unit) {
                $unit->addWeapons($weapon);
                $em->persist($unit);
                $em->flush($unit);
            }
//            $em->persist($weapon);
//            $em->flush($weapon);
            return $this->redirectToRoute('wp_show', array('id' => $weapon->getId()));
        }

        return $this->render('@ArmyData/Weapon/edit_wp.html.twig', array(
            'weapon' => $weapon,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction(Request $request, Weapon $weapon)
    {
        $form = $this->createDeleteForm($weapon);
        $form->handleRequest($request);
        if (!$weapon) {
            throw $this->createNotFoundException("Destinatari no trobat");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($weapon);
        $em->flush($weapon);

        return $this->redirectToRoute('wp_index');
    }
}
