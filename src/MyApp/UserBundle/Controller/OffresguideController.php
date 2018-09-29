<?php

namespace MyApp\UserBundle\Controller;

use MyApp\AdminBundle\Entity\Offresguide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\UserBundle\OffresguidesRecherche;
use Symfony\Component\HttpFoundation\JsonResponse;

class OffresguideController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public function showAllAction()
    {
        $offresguide=new Offresguide();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('MyApp\UserBundle\Form\OffresguidesRecherche', $offresguide);
        $offresguides = $em->getRepository('MyAppAdminBundle:Offresguide')->findBy(array(),array('id' =>"DESC"),2,0);



        return $this->render('MyAppUserBundle:guide:show.html.twig', array(
            'offresguides' => $offresguides,'form' => $form->createView()
        ));
    }
    public function showAfriqueAction()
    {
        $offresguide= new Offresguide();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('MyApp\UserBundle\Form\OffresguidesRecherche', $offresguide);
        $offresguides = $em->getRepository('MyAppAdminBundle:Offresguide')->findBy(array('continent'=>'Afrique'));



        return $this->render('MyAppUserBundle:guide:ShowAfrique.html.twig', array(
            'offresguides' => $offresguides,'form' => $form->createView()
        ));
    }

    public function showAsieAction()
    {
        $offresguide= new Offresguide();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('MyApp\UserBundle\Form\OffresguidesRecherche', $offresguide);
        $offresguides = $em->getRepository('MyAppAdminBundle:Offresguide')->findBy(array('continent'=>'Asie'));



        return $this->render('MyAppUserBundle:guide:ShowAsie.html.twig', array(
            'offresguides' => $offresguides,'form' => $form->createView()
        ));
    }

    public function showEuropeAction()
    {
        $offresguide= new Offresguide();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('MyApp\UserBundle\Form\OffresguidesRecherche', $offresguide);
        $offresguides = $em->getRepository('MyAppAdminBundle:Offresguide')->findBy(array('continent'=>'Europe'));



        return $this->render('MyAppUserBundle:guide:ShowEurope.html.twig', array(
            'offresguides' => $offresguides,'form' => $form->createView()
        ));
    }

    public function showAmeriqueNordAction()
    {
        $offresguide= new Offresguide();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('MyApp\UserBundle\Form\OffresguidesRecherche', $offresguide);
        $offresguides = $em->getRepository('MyAppAdminBundle:Offresguide')->findBy(array('continent'=>'Amérique du nord'));



        return $this->render('MyAppUserBundle:guide:ShowAmeriqueNord.html.twig', array(
            'offresguides' => $offresguides,'form' => $form->createView()
        ));
    }

    public function showAmeriqueSudAction()
    {
        $offresguide= new Offresguide();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('MyApp\UserBundle\Form\OffresguidesRecherche', $offresguide);
        $offresguides = $em->getRepository('MyAppAdminBundle:Offresguide')->findBy(array('continent'=>'Amérique du sud'));



        return $this->render('MyAppUserBundle:guide:ShowAmeriquSud.html.twig', array(
            'offresguides' => $offresguides,'form' => $form->createView()
        ));
    }

    public function showOcéanieAction()
    {
        $offresguide= new Offresguide();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('MyApp\UserBundle\Form\OffresguidesRecherche', $offresguide);
        $offresguides = $em->getRepository('MyAppAdminBundle:Offresguide')->findBy(array('continent'=>'Océanie'));



        return $this->render('MyAppUserBundle:guide:ShowOceanie.html.twig', array(
            'offresguides' => $offresguides,'form' => $form->createView()
        ));
    }


    public function lieuxDetailOffreAction( $id)
    {
        $em=$this->getDoctrine()->getManager();
        $lieux=$em->getRepository('MyAppAdminBundle:LieuxAVisiter')->findBy(array('idGuide'=>$id));
        return $this->render('MyAppUserBundle:lieu:LieuxParOffre.html.twig',array('lieux'=>$lieux, 'id_guide'=>$id));
    }


    public function affichageFrontAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $offre=$em->getRepository('MyAppAdminBundle:Offresguide')->find($id);
        $cuisine = $em->getRepository('MyAppAdminBundle:Cuisine')->findBy(array('idGuide' => $offre));
        $lieu = $em->getRepository('MyAppAdminBundle:LieuxAVisiter')->findBy(array('idGuide' => $offre));

        return $this->render('MyAppUserBundle:guide:affichageFront.html.twig', array(
            'offre' => $offre, 'cuisine' =>$cuisine,'lieu'=>$lieu

        ));
    }


    public function CuisineDetailOffreAction( $id)
    {
        $em=$this->getDoctrine()->getManager();
        $cuisine=$em->getRepository('MyAppAdminBundle:Cuisine')->findBy(array('idGuide'=>$id));
        return $this->render('MyAppUserBundle:cuisine:CuisineParOffre.html.twig',array('cuisine'=>$cuisine, 'idguide'=>$id));
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

        $offres = $em->getRepository('MyAppAdminBundle:Offresguide')->findBy(array(),array('id' =>"DESC"),2,0+$im);

        foreach ($offres as $offre){
            $v[$offre->getId()] = array($offre->getDescriptif(),
                $offre->getIdPays()->getLibelle(),$offre->getIdVille()->getLibelleVille()
            ,$offre->getMonnaie(),$offre->getPath(),$offre->getTitre(),
                $offre->getId());
        }
        $response = new JsonResponse();
        return $response->setData($v);
    }


 public function VisiterMapAction($id)
{

    $em = $this->getDoctrine()->getManager();
    $offre=$em->getRepository('MyAppAdminBundle:Offresguide')->find($id);
    return $this->render('MyAppUserBundle:guide:map.html.twig', array(
        'offre' => $offre

    ));
}



    public function ShowMapAction(){
        return $this->render('MyAppUserBundle:guide:hotel.html.twig');
    }
}