<?php

namespace ArmyDataBundle\Controller;

use ArmyDataBundle\Entity\Army;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use ArmyDataBundle\Entity\Weapon;
use Symfony\Component\HttpFoundation\File\File;

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
            if ($weapon->getImage()) {
                $file = $weapon->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $imgRoute = $this->container->getParameter('weapon_directory');
                $file->move(
                    $imgRoute,
                    $fileName
                );
                $weapon->setImage($fileName);
            } else {
                //in case there is no image puts one by default
                $weapon->setImage("giphy.gif");
            }
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
        $weapon->setImage(new File($this->getParameter('unit_directory') . '/' . $weapon->getImage()));
        $imgOri = basename($weapon->getImage());
        $deleteForm = $this->createDeleteForm($weapon);
        $editForm = $this->createForm('ArmyDataBundle\Form\WeaponType', $weapon);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($weapon->getImage()) {
                $file = $weapon->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $imgRoute = $this->container->getParameter('weapon_directory');
                $file->move(
                    $imgRoute,
                    $fileName
                );
                $weapon->setImage($fileName);
            } else {
                $weapon->setImage($imgOri);
            }
            $units = $weapon->getUnits();
            $armies = $weapon->getArmies();
            $em = $this->getDoctrine()->getManager();
            $armiesList = $em->getRepository('ArmyDataBundle:Army')->findAll();
            $unitsList = $em->getRepository('ArmyDataBundle:Unit')->findAll();
            $armyEditList = array();
            $unitEditList = array();

            foreach ($armies as $army) {
                $armyCollect = $em->getRepository('ArmyDataBundle:Army')->findCollect($army->getId());
                array_push($armyEditList, $armyCollect);
            }
            //part d'eliminar
            //Si la array ve buida
            if (empty($armyEditList)) {
                foreach ($armiesList as $armyList) {
                    $armyList->removeWeapons($weapon);
                    $weapon->removeArmies($armyList);
                    $em->persist($armyList);
                    $em->flush($armyList);
                    $em->persist($weapon);
                    $em->flush($weapon);
                }
            } else {
                //eliminar en cas no estigui a la llista del formulari per si a la base de dades
                foreach ($armiesList as $armyList) {
                    $weaponIsInList = $armyList->getWeapons()->contains($weapon);
                    if ($weaponIsInList && !$weapon->getArmies()->contains($armyList)) {
                        $armyList->removeWeapons($weapon);
                        $weapon->removeArmies($armyList);
                        $em->persist($armyList);
                        $em->flush($armyList);
                        $em->persist($weapon);
                        $em->flush($weapon);
                    }
                }
            }
            foreach ($armies as $army) {
                $army->addWeapons($weapon);
                $em->persist($army);
                $em->flush($army);
            }

            foreach ($units as $unit) {
                $unitCollect = $em->getRepository('ArmyDataBundle:Unit')->findCollect($unit->getId());
                array_push($unitEditList, $unitCollect);
            }
            if (empty($unitEditList)) {
                foreach ($unitsList as $unitList) {
                    $unitList->removeWeapons($weapon);
                    $weapon->removeUnits($unitList);
                    $em->persist($unitList);
                    $em->flush($unitList);
                    $em->persist($weapon);
                    $em->flush($weapon);
                }
            } else {
                //eliminar en cas no estigui a la llista del formulari per si a la base de dades
                foreach ($unitsList as $unitList) {
                    $weaponIsInList = $unitList->getWeapons()->contains($weapon);
                    if ($weaponIsInList && !$weapon->getUnits()->contains($unitList)) {
                        $unitList->removeWeapons($weapon);
                        $weapon->removeUnits($unitList);
                        $em->persist($unitList);
                        $em->flush($unitList);
                        $em->persist($weapon);
                        $em->flush($weapon);
                    }
                }
            }
            foreach ($units as $unit) {
                $unit->addWeapons($weapon);
                $em->persist($unit);
                $em->flush($unit);
            }
            $em->persist($weapon);
            $em->flush($weapon);
            return $this->redirectToRoute('wp_show', array('id' => $weapon->getId()));
        }

        return $this->render('@ArmyData/Weapon/edit_wp.html.twig', array(
            'weapon' => $weapon,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public
    function deleteAction(Request $request, Weapon $weapon)
    {
        $imgDel = new File($this->getParameter('weapon_directory') . '/' . $weapon->getImage());
        $form = $this->createDeleteForm($weapon);
        $form->handleRequest($request);
        if (!$weapon) {
            throw $this->createNotFoundException("Destinatari no trobat");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($weapon);
        $em->flush($weapon);

        if (basename($imgDel) != 'giphy.gif'){
            unlink($imgDel);
        }

        return $this->redirectToRoute('wp_index');
    }
}
