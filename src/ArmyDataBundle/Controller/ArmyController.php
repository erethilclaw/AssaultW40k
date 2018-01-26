<?php

namespace ArmyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ArmyDataBundle\Entity\Unit;
use ArmyDataBundle\Entity\Army;

class ArmyController extends Controller
{
    public function indexAction()
    {
        $armies = $this->getDoctrine()->getRepository('ArmyDataBundle:Army')->findAll();
        return $this->render('ArmyDataBundle:Army:index.html.twig',array('armies' => $armies));
    }

    public function addAction(Request $request)
    {
        $army = new Army();
        $form = $this->createForm('ArmyDataBundle\Form\ArmyType' , $army);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $army->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $imgRoute = $this->container->getParameter('kernel.root_dir').'/../web/uploads/army';
            $file->move(
                $imgRoute,
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $army->setImage($fileName);

            // ... persist the $product variable or any other work

            $em = $this->getDoctrine()->getManager();
            $em->persist($army);
            $em->flush($army);

          return $this->redirectToRoute('army_show', array('id' => $army->getId()));
        }

        return $this->render('@ArmyData/Army/add_army.html.twig', array(
            'army' => $army,
            'form' => $form->createView(),
        ));
    }

    public function showAction(Army $army)
    {
        $deleteForm = $this->createDeleteForm($army);

        return $this->render('ArmyDataBundle:Army:show_army.html.twig', array(
            'army' => $army,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    private function createDeleteForm(Army $army)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('army_delete', array('id' => $army->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function editAction(Request $request, Army $army)
    {
        $imgRoute = $this->container->getParameter('kernel.root_dir').'/../web/uploads/army';
        $army->setImage(new File($imgRoute.'/'.$army->getImage()));
        $deleteForm = $this->createDeleteForm($army);
        $editForm = $this->createForm( 'ArmyDataBundle\Form\ArmyType',$army);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $army->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $imgRoute = $this->container->getParameter('kernel.root_dir').'/../web/uploads/army';
            $file->move(
                $imgRoute,
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $army->setImage($fileName);

            // ... persist the $product variable or any other work
            $this->getDoctrine()->getManager()->persist($army);
            $this->getDoctrine()->getManager()->flush($army);

            return $this->redirectToRoute('army_show', array('id' => $army->getId()));
        }

        return $this->render('@ArmyData/Army/edit_army.html.twig', array(
            'army' => $army,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction(Request $request, Army $army)
    {
        $form = $this->createDeleteForm($army);
        $form->handleRequest($request);

        if (!$army){
            throw $this->createNotFoundException("Destinatari no trobat");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($army);
        $em->flush($army);


        return $this->redirectToRoute('army_index');
    }
}
