<?php

namespace ArmyDataBundle\Controller;

use ArmyDataBundle\Entity\Army;
use ArmyDataBundle\Form\UnitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ArmyDataBundle\Entity\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;

class UnitController extends Controller
{
    public function indexAction()
    {
        $units = $this->getDoctrine()->getRepository('ArmyDataBundle:Unit')->findAll();
        return $this->render('ArmyDataBundle:Unit:index.html.twig',array('units' => $units));
    }

    public function addAction(Request $request)
    {
        $unit = new Unit();
        $form = $this->createForm(UnitType::class, $unit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($unit->getImage()) {
                $file = $unit->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $imgRoute = $this->container->getParameter('unit_directory');
                $file->move(
                    $imgRoute,
                    $fileName
                );
                $unit->setImage($fileName);
            } else {
                //in case there is no image puts one by default
                $unit->setImage("giphy.gif");
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($unit);
            $em->flush($unit);


          return $this->redirectToRoute('unit_show', array('id' => $unit->getId()));
        }

        return $this->render('@ArmyData/Unit/add_unit.html.twig', array(
            'unit' => $unit,
            'form' => $form->createView(),
        ));
    }

    public function showAction(Unit $unit)
    {
        $deleteForm = $this->createDeleteForm($unit);
        return $this->render('@ArmyData/Unit/show_unit.html.twig', array(
            'unit' => $unit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    private function createDeleteForm(Unit $unit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unit_delete', array('id' => $unit->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function editAction(Request $request, Unit $unit)
    {
        $unit->setImage(new File($this->getParameter('unit_directory') . '/' . $unit->getImage()));
        $imgOri = basename($unit->getImage());
        $deleteForm = $this->createDeleteForm($unit);
        $editForm = $this->createForm( 'ArmyDataBundle\Form\UnitType',$unit);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($unit->getImage()) {
                $file = $unit->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $imgRoute = $this->container->getParameter('unit_directory');
                $file->move(
                    $imgRoute,
                    $fileName
                );
                $unit->setImage($fileName);
            } else {
                $unit->setImage($imgOri);
            }
            $this->getDoctrine()->getManager()->persist($unit);
            $this->getDoctrine()->getManager()->flush($unit);

            return $this->redirectToRoute('unit_show', array('id' => $unit->getId()));
        }

        return $this->render('@ArmyData/Unit/edit_unit.html.twig', array(
            'unit' => $unit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction(Request $request, Unit $unit)
    {
        $imgDel = new File($this->getParameter('unit_directory') . '/' . $unit->getImage());
        $form = $this->createDeleteForm($unit);
        $form->handleRequest($request);

        if (!$unit){
            throw $this->createNotFoundException("Destinatari no trobat");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($unit);
        $em->flush($unit);

        if (basename($imgDel) != 'giphy.gif'){
            unlink($imgDel);
        }

        return $this->redirectToRoute('unit_index');
    }
}
