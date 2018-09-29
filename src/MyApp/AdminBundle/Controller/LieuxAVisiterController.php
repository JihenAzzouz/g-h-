<?php

namespace MyApp\AdminBundle\Controller;

use MyApp\AdminBundle\Entity\LieuxAVisiter;
use MyApp\AdminBundle\Entity\Offresguide;
use MyApp\AdminBundle\Form\LieuxAVisiterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Lieuxavisiter controller.
 *
 */
class LieuxAVisiterController extends Controller
{
    /**
     * Lists all lieuxAVisiter entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lieuxAVisiters = $em->getRepository('MyAppAdminBundle:LieuxAVisiter')->findAll();

        return $this->render('lieuxavisiter/index.html.twig', array(
            'lieuxAVisiters' => $lieuxAVisiters,
        ));
    }

    /**
     * Creates a new lieuxAVisiter entity.
     *
     */
    public function newAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();

        $offre=$em->getRepository('MyAppAdminBundle:Offresguide')->find($id);
        $lieuxAVisiter = new Lieuxavisiter();
        $lieuxAVisiter->setIdGuide($offre);

            $form = $this->createForm('MyApp\AdminBundle\Form\LieuxAVisiterType', $lieuxAVisiter);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $lieuxAVisiter->upload();
            $em->persist($lieuxAVisiter);
            $em->flush();

           return $this->redirectToRoute('lieux', array('id' => $id));
        }

        return $this->render('MyAppAdminBundle:lieuxavisiter:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a lieuxAVisiter entity.
     *
     */
    public function showAction(LieuxAVisiter $lieuxAVisiter)
    {
        $deleteForm = $this->createDeleteForm($lieuxAVisiter);

        return $this->render('lieuxavisiter/ShowAsie.html.twig', array(
            'lieuxAVisiter' => $lieuxAVisiter,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing lieuxAVisiter entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $lieu=$em->getRepository('MyAppAdminBundle:LieuxAVisiter')->find($id);
        $form=$this->createForm(LieuxAVisiterType::class,$lieu);
        if($form->handleRequest($request)->isValid())
        {
            $em->persist($lieu);
            $em->flush();
            return $this->redirectToRoute('lieux',array('id'=>$lieu->getIdGuide()->getId()));
        }
        return $this->render('MyAppAdminBundle:lieuxavisiter:new.html.twig',
            array ('form'=>$form->createView()));
    }

    /**
     * Deletes a lieuxAVisiter entity.
     *
     */
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $lieu=$em->getRepository('MyAppAdminBundle:LieuxAVisiter')->find($id);
        $em->remove($lieu);
        $em->flush();
        return $this->redirectToRoute('lieux',array('id'=>$lieu->getIdGuide()->getId()));
    }



    private function createDeleteForm(LieuxAVisiter $lieuxAVisiter)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lieuxavisiter_delete', array('id' => $lieuxAVisiter->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function lieuxDetailOffreAction( $id)
    {
        $em=$this->getDoctrine()->getManager();
        $lieux=$em->getRepository('MyAppAdminBundle:LieuxAVisiter')->findBy(array('idGuide'=>$id));
        return $this->render('MyAppAdminBundle:lieuxavisiter:LieuxParOffre.html.twig',array('lieux'=>$lieux, 'id_guide'=>$id));
    }

}
