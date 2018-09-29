<?php

namespace MyApp\AdminBundle\Controller;

use MyApp\AdminBundle\Entity\Offresguide;
use MyApp\AdminBundle\Form\OffresguideType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Offresguide controller.
 *
 */
class OffresguideController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $offresguides = $em->getRepository('MyAppAdminBundle:Offresguide')->findAll();

        return $this->render('offresguide/index.html.twig', array(
            'offresguides' => $offresguides,
        ));
    }

    public function showAllAction(Request $request)
    {
        $offresguide=new Offresguide();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('MyApp\AdminBundle\Form\OffresguideRecherche', $offresguide);
        $offresguides = $em->getRepository('MyAppAdminBundle:Offresguide')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $offresguides,
            $request->query->getInt('page', 1),
            2   );

        return $this->render('@MyAppAdmin/offresguide/show.html.twig', array(
            'offresguides' => $pagination,'form' => $form->createView()
        ));
    }
    public function showAllFrontAction()
    {
        $offresguide=new Offresguide();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('MyApp\AdminBundle\Form\OffresguideRecherche', $offresguide);
        $offresguides = $em->getRepository('MyAppAdminBundle:Offresguide')->findBy(array(),array('id' =>"DESC"));





    $cuisine = $em->getRepository('MyAppAdminBundle:Cuisine')->findBy(array('idGuide' => $offresguides));
    //  $lieu = $em->getRepository('MyAppAdminBundle:LieuxAVisiter')->findBy(array('idGuide' => $offresguides));



        return $this->render('@MyAppAdmin/offresguide/showfront.hmtl.twig', array(
            'offresguides' => $offresguides, 'cuisine'=>$cuisine,'form' => $form->createView()
        ));
    }

    /**
     * Creates a new offresguide entity.
     *
     */
    public function newAction(Request $request)
    {
        $offresguide = new Offresguide();
        $form = $this->createForm('MyApp\AdminBundle\Form\OffresguideType', $offresguide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $offresguide->upload();
            $em->persist($offresguide);
            $em->flush();

            return $this->redirectToRoute('offresguide_new');
        }

        return $this->render('MyAppAdminBundle:offresguide:new.html.twig', array(
            'offresguide' => $offresguide,
            'form' => $form->createView(),
        ));
    }




    /**
     * Displays a form to edit an existing offresguide entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $offre=$em->getRepository('MyAppAdminBundle:Offresguide')->find($id);
        $form=$this->createForm(OffresguideType::class,$offre);
        if($form->handleRequest($request)->isValid())
        {
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('offresguide_showAll');
        }
        return $this->render('MyAppAdminBundle:offresguide:new.html.twig',
            array ('form'=>$form->createView()));
    }


    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository('MyAppAdminBundle:Offresguide')->find($id);
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute('offresguide_showAll');
    }




    public function detailOffreAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $offre=$em->getRepository('MyAppAdminBundle:Offresguide')->find($id);
        $cuisine = $em->getRepository('MyAppAdminBundle:Cuisine')->findBy(array('idGuide' => $offre));
        $lieu = $em->getRepository('MyAppAdminBundle:LieuxAVisiter')->findBy(array('idGuide' => $offre));

        return $this->render('MyAppAdminBundle:offresguide:affichage.html.twig', array(
            'offre' => $offre, 'cuisine' =>$cuisine,'lieu'=>$lieu

        ));
    }

    function OffreParPaysAction($pays){

        $em = $this->getDoctrine()->getManager();
         $payss=$em->getRepository('MyAppUserBundle:Pays')->find($pays);
        $guide = $em->getRepository('MyAppAdminBundle:Offresguide')->findBy(array('idPays' => $payss));

        foreach ($guide as $guides){
            $v[$guides->getId()] = array($guides->getDescriptif(),
                $guides->getIdPays()->getLibelle(),$guides->getIdVille()->getLibelleVille()
            ,$guides->getMonnaie(),$guides->getPath(),$guides->getTitre(),
                $guides->getId());
        }
        $response = new JsonResponse();
        return $response->setData($v);
    }
    function villeAction($idpays){

        $em = $this->getDoctrine()->getManager();
        $villes = $em->getRepository('MyAppUserBundle:Ville')->findBy(array('idPays'=>$idpays));
        foreach ($villes as $ville){

            $v[$ville->getId()] = array($ville->getLibelleVille(), $ville->getId());

        }
        $response = new JsonResponse();
        return $response->setData($v);
    }


    function AfficherSansFiltreAction($im){

        $em = $this->getDoctrine()->getManager();

        $offres = $em->getRepository('MyAppAdminBundle:Offresguide')->findAll();

        foreach ($offres as $offre){
            $v[$offre->getId()] = array($offre->getDescriptif(),
                $offre->getIdPays()->getLibelle(),$offre->getIdVille()->getLibelleVille()
            ,$offre->getMonnaie(),$offre->getPath(),$offre->getTitre(),
                $offre->getId());
        }
        $response = new JsonResponse();
        return $response->setData($v);
    }

    public function ShowMapAction(){
        return $this->render('@MyAppAdmin/offresguide/mapShow.html.twig');
    }








}
