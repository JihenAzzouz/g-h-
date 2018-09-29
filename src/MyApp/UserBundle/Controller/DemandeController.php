<?php

namespace MyApp\UserBundle\Controller;

use MyApp\UserBundle\Entity\Demande;
use MyApp\UserBundle\Form\DemandeType;
use MyApp\UserBundle\Form\PaysType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Demande controller.
 *
 */
class DemandeController extends Controller
{

    /**
     * Creates a new demande entity.
     *
     */
    public function AjouterDemandeAction(Request $request)
    {
        $demande = new Demande();

        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setIdUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($demande);

            $em->flush();
            $this->get('session')->getFlashBag()->add('message', 'L\'article a bien été ajoutée !');
            return $this->redirectToRoute('AllMydemande_show');
        }

        return $this->render('MyAppUserBundle:demande:AjouterDemande.html.twig', array(
            'demande' => $demande,
            'form' => $form->createView()
        ));
    }

    public function AfficherMesDemandeAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $demandes = $em->getRepository('MyAppUserBundle:Demande')->findBy(array('idUser' => $this->getUser()),array('dateAjout'=>"DESC"));
      //  $nbdemande = $em->getRepository('MyAppUserBundle:Demande')->findNbDemandeParUser($this->getUser());
        $paginator = $this->get('knp_paginator');


        $pagination = $paginator->paginate(
            $demandes,
            $request->query->getInt('page', 1),
            6);
        return $this->render('MyAppUserBundle:demande:MesDemandes.html.twig', array(
            'demandes' => $pagination , 'd'=>$demandes
        ));

    }

    public function detailDemandeAction(Demande $demande)
    {


        return $this->render('', array(
            'demande' => $demande

        ));
    }

    function supprimerAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository('MyAppUserBundle:Demande')->find($id);
        $em->remove($demande);
        $em->flush();
        return $this->redirectToRoute('AllMydemande_show');
    }

    public function AfficherDemandeAction(Demande $demande)
    {


        return $this->render('MyAppUserBundle:demande:AfficherDemande.html.twig', array(
            'demande' => $demande

        ));
    }

    public function afficherTouteDemandeAction(Request $request)
    {
        $demande= new Demande();
        $em = $this->getDoctrine()->getManager();
        $rechercheForm=$this->createForm('MyApp\UserBundle\Form\DemandeSearch', $demande);
        $demandes = $em->getRepository('MyAppUserBundle:Demande')->findBy(array(),array('dateDebut' =>"DESC"),2,0);
        $nbdemande = $em->getRepository('MyAppUserBundle:Demande')->findAll();
        return $this->render('MyAppUserBundle:demande:AfficherLesDemande.html.twig', array(
            'demandes' => $demandes,'form'=>$rechercheForm->createView(),'nbdemande'=>$nbdemande
        ));

    }
    public function ModifierDemandeAction($id,Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        $demande=$em->getRepository('MyAppUserBundle:Demande')->find($id);
        $dataAjout=$demande->getDateAjout();
        $form=$this->createForm('MyApp\UserBundle\Form\DemandeType',$demande);
        if($form->handleRequest($req)->isValid())
        {
            $demande->setDateAjout($dataAjout);
            $demande->setDateDerniereModif(new \DateTime('now'));

            $em->persist($demande);
            $em->flush();
            return $this->redirect($this->generateUrl('AllMydemande_show'));

        }
        return $this->render('MyAppUserBundle:demande:AjouterDemande.html.twig',
            array ('form'=>$form->createView()));
    }

    public function MesAnnonceAproposerAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $annonces = $em->getRepository('MyAppUserBundle:Annonce')->findBy(array('idUser' => $this->getUser()));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonces,
            $request->query->getInt('page', 1),
            6   );
        return $this->render('MyAppUserBundle:demande:MesAnnonces.html.twig', array(
            'page' => $pagination,
            'id_demande'=>$id
        ));

    }

    function RechercheVilleAction($idpays){

        $em = $this->getDoctrine()->getManager();
        $villes = $em->getRepository('MyAppUserBundle:Ville')->findBy(array('idPays'=>$idpays));
        foreach ($villes as $ville){
            $v[$ville->getId()] = array($ville->getLibelleVille(), $ville->getId());
        }
        $response = new JsonResponse();
        return $response->setData($v);
    }

    function RechercheParLogementAction($logement){

        $em = $this->getDoctrine()->getManager();
        $v=null;
        $demande = $em->getRepository('MyAppUserBundle:Demande')->findBy(array('typeMaison' => $logement));

        foreach ($demande as $demandes){
            $v[$demandes->getId()] = array($demandes->getTypeLogement(),
               $demandes->getDateDebut(),$demandes->getDateFin(),$demandes->getDescription(),
               $demandes->getVille()->getLibelleVille(),$demandes->getPays()->getLibelle(),$demandes->getId(),$demandes->getPrix());
        }
        $response = new JsonResponse();
        return $response->setData($v);
    }

    function AfficherDemandeSansFiltreAction($im){

        $em = $this->getDoctrine()->getManager();
        $v=null;
        $demande = $em->getRepository('MyAppUserBundle:Demande')->findBy(array(),array('dateDebut' =>'ASC'),2,0+$im);

        foreach ($demande as $demandes){
            $v[$demandes->getId()] = array($demandes->getTypeLogement(),
                $demandes->getDateDebut(),$demandes->getDateFin(),$demandes->getDescription(),
                $demandes->getVille()->getLibelleVille(),$demandes->getPays()->getLibelle(),$demandes->getId(),$demandes->getPrix());
        }
        $response = new JsonResponse();
        return $response->setData($v);
    }


    function demandefiltrePaysAction($pays,$im){

        $em = $this->getDoctrine()->getManager();
        $v=null;
        $payss=$em->getRepository('MyAppUserBundle:Pays')->find($pays);
        $demande = $em->getRepository('MyAppUserBundle:Demande')->findBy(array('pays' => $payss),array('dateDebut' =>'ASC'),2,0+$im);

        foreach ($demande as $demandes){
            $v[$demandes->getId()] = array($demandes->getTypeLogement(),
                $demandes->getDateDebut(),$demandes->getDateFin(),$demandes->getDescription(),
                $demandes->getVille()->getLibelleVille(),$demandes->getPays()->getLibelle(),$demandes->getId(),$demandes->getPrix());
        }
        $response = new JsonResponse();
        return $response->setData($v);
    }

    function demandefiltrePaysVilleAction($ville,$im){

        $em = $this->getDoctrine()->getManager();
        $villes=$em->getRepository('MyAppUserBundle:Ville')->find($ville);

        $demande = $em->getRepository('MyAppUserBundle:Demande')->findBy(array('ville' => $villes),array('dateDebut' =>'ASC'),2,0+$im);
        $v=null;
        foreach ($demande as $demandes){
            $v[$demandes->getId()] = array($demandes->getTypeLogement(),
                $demandes->getDateDebut(),$demandes->getDateFin(),$demandes->getDescription(),
                $demandes->getVille()->getLibelleVille(),$demandes->getPays()->getLibelle(),$demandes->getId(),$demandes->getPrix());
        }
        $response = new JsonResponse();
        return $response->setData($v);
    }

    function afficheplusAction($im){

        $em = $this->getDoctrine()->getManager();
        $v=null;
        $demande = $em->getRepository('MyAppUserBundle:Demande')->findBy(array(),array('dateDebut' => 'ASC'),2,0+$im);

        foreach ($demande as $demandes){
            $v[$demandes->getId()] = array($demandes->getTypeLogement(),
                $demandes->getDateDebut(),$demandes->getDateFin(),$demandes->getDescription(),
                $demandes->getVille()->getLibelleVille(),$demandes->getPays()->getLibelle(),$demandes->getId(),$demandes->getPrix());
        }
        $response = new JsonResponse();
        return $response->setData($v);
    }

}
