<?php

namespace MyApp\AdminBundle\Controller;

use MyApp\AdminBundle\Entity\Cuisine;
use MyApp\AdminBundle\Form\CuisineType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cuisine controller.
 *
 */
class CuisineController extends Controller
{
    /**
     * Lists all cuisine entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cuisines = $em->getRepository('MyAppAdminBundle:Cuisine')->findAll();

        return $this->render('cuisine/index.html.twig', array(
            'cuisines' => $cuisines,
        ));
    }

    /**
     * Creates a new cuisine entity.
     *
     */
    public function newAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();

        $offre=$em->getRepository('MyAppAdminBundle:Offresguide')->find($id);
        $cuisine = new Cuisine();
        $cuisine->setIdGuide($offre);

        $form = $this->createForm('MyApp\AdminBundle\Form\CuisineType', $cuisine);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $cuisine->upload();
            $em->persist($cuisine);
            $em->flush();

            return $this->redirectToRoute('cuisine', array('id' => $id));
        }

        return $this->render('MyAppAdminBundle:cuisine:new.html.twig', array(
            'form' => $form->createView(),'idguide'=>$id
        ));
    }

    /**
     * Finds and displays a cuisine entity.
     *
     */
    public function showAction(Cuisine $cuisine)
    {
        $deleteForm = $this->createDeleteForm($cuisine);

        return $this->render('cuisine/ShowAsie.html.twig', array(
            'cuisine' => $cuisine,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cuisine entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cuisine=$em->getRepository('MyAppAdminBundle:Cuisine')->find($id);
        $form=$this->createForm(CuisineType::class,$cuisine);
        if($form->handleRequest($request)->isValid())
        {
            $em->persist($cuisine);
            $em->flush();
            return $this->redirectToRoute('cuisine',array('id'=>$cuisine->getIdGuide()->getId()));
        }
        return $this->render('MyAppAdminBundle:cuisine:new.html.twig',
            array ('form'=>$form->createView()));
    }

    /**
     * Deletes a cuisine entity.
     *
     */
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $cuisine=$em->getRepository('MyAppAdminBundle:Cuisine')->find($id);
        $em->remove($cuisine);
        $em->flush();
        return $this->redirectToRoute('cuisine',array('id'=>$cuisine->getIdGuide()->getId()));
    }

    /**
     * Creates a form to delete a cuisine entity.
     *
     * @param Cuisine $cuisine The cuisine entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cuisine $cuisine)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cuisine_delete', array('id' => $cuisine->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function CuisineDetailOffreAction( $id)
    {
        $em=$this->getDoctrine()->getManager();
        $cuisine=$em->getRepository('MyAppAdminBundle:Cuisine')->findBy(array('idGuide'=>$id));
        return $this->render('MyAppAdminBundle:cuisine:CuisineParOffre.html.twig',array('cuisine'=>$cuisine, 'idguide'=>$id));
    }
}
