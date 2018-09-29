<?php


namespace MyApp\UserBundle\Controller;
use MyApp\UserBundle\Entity\Commentaire;
use MyApp\UserBundle\Entity\CommetReply;

use MyApp\UserBundle\Form\CommentaireType;
use MyApp\UserBundle\Form\CommetReplyType;
use MyApp\UserBundle\Form\ReservationType;
use MyApp\UserBundle\Entity\Reservation;
use MyApp\UserBundle\Entity\Image;
use MyApp\UserBundle\Form\AnnonceRechercheMap;
use MyApp\UserBundle\Form\AnnonceRechercheTypeForm;
use MyApp\UserBundle\Form\AnnonceType;
use MyApp\UserBundle\Form\AnnonceTypeForm;
use MyApp\UserBundle\Form\AnnonceTypeModifier;
use MyApp\UserBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\UserBundle\Entity\Categorie;
use MyApp\UserBundle\Entity\User;
use MyApp\UserBundle\Entity\Reponse;
use Symfony\Component\DependencyInjection\Tests\Compiler\I;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use MyApp\UserBundle\Entity\Annonce;
class AnnonceController extends Controller
{
    public function createVehicleAction(Request $request)
    {
        $formData = new Annonce(); // Your form data class. Has to be an object, won't work properly with an array.
        $formData->setIdUser($this->getUser());
        $s = new Image();
        $s1 = new Image();
        $s2 = new Image();


        $flow = $this->get('my_app_user.form.flow.createVehicle'); // must match the flow's service id
        $flow->bind($formData);

        // form of the current step
        $form = $flow->createForm();

        if(($flow->isValid($form)))
        {
            $flow->saveCurrentStepData($form);
            if ($flow->nextStep()) {
            // form for the next step
            $form = $flow->createForm();
        }
      else {


          if (($formData->getDateDebut() < $formData->getDateFin())&&($formData->getDateDebut()> new \DateTime('now') )) {
              $s->setFile($formData->getFile1());
              $s->upload();
              $s1->setFile($formData->getFile2());
              $s1->upload();
              $s2->setFile($formData->getFile3());
              $s2->upload();

              // dump($s1);die();
              $s->setIdAnnonce($formData);
              $s1->setIdAnnonce($formData);
              $s2->setIdAnnonce($formData);


              $em = $this->getDoctrine()->getManager();
              $em->persist($formData);


              $em->persist($s);
              $em->persist($s1);
              $em->persist($s2);
              $em->flush();
              $flow->reset();
              // remove step data from the session

              $this->get('ras_flash_alert.alert_reporter')->addSuccess("annonce ajoutée avec succes");

              return $this->redirectToRoute('afficherAnnonceUser');


          }
          elseif (($formData->getDateDebut() > $formData->getDateFin())||($formData->getDateDebut()< new \DateTime('now') ))
          {
              $this->get('ras_flash_alert.alert_reporter')->addError("Veuillez revoir les dates");

          }
      }


        }

        return $this->render('MyAppUserBundle:Annonce:ajoutAnnonce.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }


    function addSpAction(Request $req)
    {
        $s = new image();
        $s1 = new image();

        $a= new Annonce();
        $a->setId($req->get('id'));
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository('MyAppUserBundle:Annonce')->find($a);
        $s->setIdAnnonce($classe);
        $form = $this->createForm(ImageType::class);
        if ($form->handleRequest($req)->isValid()) {
        $s->setFile($form->get('file'));
        $s->upload();
        $s1->setFile($form->get('file2'));
        dump(s1);die();
            $s1->upload();

            $em->persist($s);
            $em->flush();
            return $this->render('::base.html.twig');
        }

        return $this->render('MyAppUserBundle:Annonce:Image.html.twig', array('f' => $form->createView()));


    }
    function AfficherAnnonceAction(Request $request)
    {

        $offre = new Annonce();
        $em=$this->getDoctrine()->getManager();
        $annonce = $em->getRepository('MyAppUserBundle:Annonce')->afficheAnnonce($this->getUser());
        $form=$this->createForm(AnnonceRechercheTypeForm::class,$offre);

        $dql   = "select s from  MyAppUserBundle:Annonce s where s.idUser<>:y";
        $query = $em->createQuery($dql)->setParameter('y',$this->getUser());
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
       if($form->handleRequest($request)->isValid()) {

            $classes = $em->getRepository('MyAppUserBundle:Annonce')->afficheHumouristeDQL($offre);


            return $this->render('MyAppUserBundle:Annonce:deco.html.twig',array('pagination' => $pagination,'f'=>$form->createView(),'d'=> $classes));

      }

        return $this->render('MyAppUserBundle:Annonce:afficherAnnonce.html.twig', array('pagination' => $pagination,'m' => $annonce,'f'=>$form->createView()));
    }
    function afficherUneAnnonceAction(Request $req)
    {
        $a = new Annonce();
        $a->setId($req->get('id'));
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('MyAppUserBundle:Annonce')->find($a);
        $ann = $em->getRepository('MyAppUserBundle:Annonce')->find($annonce);

        $msg='';
        $reservation = new Reservation();

        $em=$this->getDoctrine()->getManager();
        $u = new User();
        $u->setId($req->get('id'));

        $user = $em->getRepository('MyAppUserBundle:User')->find($u);
        $reservation->setEtat("En Attente");
        $reservation->setIdUser($user);

        $reservation->setIdAnnonce($annonce);
        $prix_nuit = $annonce->getPrix();
        $reservation->setPrixNuite($prix_nuit);
        $annonce_debut = $annonce->getDateDebut();
        $annonce_fin = $annonce->getDateFin();

        // $reservation->setDateDemande(new \DateTime('now'));

        $form = $this->createForm(ReservationType::class, $reservation);



        if(($form->handleRequest($req)->isValid()) ) {

            $fin = $form->get('dateFin')->getData();
            $debut = $form->get('dateDebut')->getData();
            if ($debut < $fin && $debut>=$annonce_debut && $fin<=$annonce_fin) {

                $nb = $debut->diff($fin);
                $nbb = $nb->format('%R%a');
                $reservation->setNbNuite($nbb);
                $total= $prix_nuit * $nbb;

                $reservation->setPrix($total);
                $em = $this->getDoctrine()->getManager();
                $em->persist($reservation);
                $em->flush();
                $this->get('ras_flash_alert.alert_reporter')->addSuccess('Demande de réservation effectuer');


            }
            else{
                $msg='Veuilez entrer des dates valides';
            }

            // return $this->redirectToRoute('afficher spectacle');

        }

        $reply = new CommetReply();
        $reply->setIdUser($this->getUser());
        $formR = $this->createForm(CommetReplyType::class, $reply);
        $commentaires = $em->getRepository('MyAppUserBundle:Commentaire')->findBy(array('idAnnonce' =>$annonce));
        $CommentaireReply = $em->getRepository('MyAppUserBundle:CommetReply')->findBy(array('idCommentaire' =>$commentaires));

        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(

            $commentaires,
            $req->query->getInt('page', 1),
            $req->query->getInt('limit', 3)

        );


        $commentaire = new Commentaire();
        $formc = $this->createForm('MyApp\UserBundle\Form\CommentaireType', $commentaire);
        $formc->handleRequest($req);

        if ($formc->isSubmitted() && $formc->isValid()) {
            $commentaire->setIdAnnonce($annonce);
            $commentaire->setIdUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            $this->get('session')->getFlashBag()->add('message', 'L\'article a bien été ajoutée !');
        }

        if($req->getMethod()=='POST' && $req->get('com') != "") {
            $idcom=$req->get('idC');
            $com= $req->get('com');
            $Commentaire = $em->getRepository('MyAppUserBundle:Commentaire')->find($idcom);
            $reply->setCommentaireReply($com);
            $reply->setIdUser($this->getUser());
            $reply->setIdCommentaire($Commentaire);
            $em->persist($reply);
            $em->flush();
        }

        return $this->render('MyAppUserBundle:Annonce:afficherUneAnnonce.html.twig',
            array('f'=>$form->createView(),'m' => $ann,'msg' => $msg,
                'commentaires' => $result, 'form' => $formR->createView(), 'reply' => $CommentaireReply,
                'com'=>$commentaires, 'formc' =>$formc->createView()
            ));

    }
    function afficherUneAnnonceUserAction(Request $req)
    {
        $a = new Annonce();
        $a->setId($req->get('id'));
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('MyAppUserBundle:Annonce')->find($a);
        $ann = $em->getRepository('MyAppUserBundle:Annonce')->find($annonce);



        $reply = new CommetReply();
        $reply->setIdUser($this->getUser());
        $form = $this->createForm(CommetReplyType::class, $reply);
        $commentaires = $em->getRepository('MyAppUserBundle:Commentaire')->findAll();
        $CommentaireReply = $em->getRepository('MyAppUserBundle:CommetReply')->findBy(array('idCommentaire' =>$commentaires));

        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(

            $commentaires,
            $req->query->getInt('page', 1),
            $req->query->getInt('limit', 3)

        );

        $commentaire = new Commentaire();
        $formC = $this->createForm(CommentaireType::class, $commentaire);
        $formC->handleRequest($req);

        if ($formC->isSubmitted() && $formC->isValid()) {

            $commentaire->setIdUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            $this->get('session')->getFlashBag()->add('message', 'L\'article a bien été ajoutée !');
        }

        return $this->render('MyAppUserBundle:Annonce:afficherUneAnnonceUser.html.twig', array('m' => $ann,
            'commentaires' => $result, 'form' => $form->createView(), 'reply' => $CommentaireReply,'com'=>$commentaires,
            'formC' => $formC->createView(),'commentaire' => $commentaire
        ));
    }

    public function rechercheAnnonceAction(Request $request)
    {
        $annonce = new Annonce();
        $form=$this->createForm(AnnonceRechercheTypeForm::class,$annonce);
        $em=$this->getDoctrine()->getManager();
        $classes=$em->getRepository('MyAppUserBundle:Annonce')->findAll();
        if($form->handleRequest($request)->isValid()){

            $classes=$em->getRepository('MyAppUserBundle:Annonce')->findBy(array('typeMaison'=>$annonce->getTypeMaison(),'typeLogement'=>$annonce->getTypeLogement(),'nbreLit'=>$annonce->getNbreLit(),'nombreVoyageur'=>$annonce->getNombreVoyageur()));

        }


        return $this->render('MyAppUserBundle:Annonce:afficherAnnonce.html.twig',array('f'=>$form->createView(),'c'=>$classes));
    }
/*
    function AffichHumAction(Request $request)
    {
        $offre = new Annonce();
        $form=$this->createForm(AnnonceRechercheTypeForm::class,$offre);
        $em=$this->getDoctrine()->getManager();
        $classes=$em->getRepository('MyAppUserBundle:Annonce')->findAll();
        $em=$this->getDoctrine()->getManager();

        if($form->handleRequest($request)->isValid()) {

            $classes = $em->getRepository('MyAppUserBundle:Annonce')->afficheHumouristeDQL($offre);

        }
        return $this->render('MyAppUserBundle:Annonce:deco.html.twig',array('f'=>$form->createView(),'m'=> $classes));
    }
    public function testMapAction()
    {
        return
 $this->render('');

    }*/

    function villeAction($idpays){

        $em = $this->getDoctrine()->getManager();
        $villes = $em->getRepository('MyAppUserBundle:Ville')->findBy(array('idPays'=>$idpays));
        foreach ($villes as $ville){

            $v[$ville->getId()] = array($ville->getLibelleVille(), $ville->getId());

        }
        $response = new JsonResponse();
        return $response->setData($v);
    }
    function afficherAnnonceUserAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $id= $this->getUser()->getId();
        $annonce = $em->getRepository('MyAppUserBundle:Annonce')->findBy(array('idUser'=>$id));

        $dql   = "select s from  MyAppUserBundle:Annonce s where s.idUser=:y";
        $query = $em->createQuery($dql)->setParameter('y',$this->getUser());
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );

   return $this->render('MyAppUserBundle:Annonce:afficherAnnonceUser.html.twig', array('pagination' => $pagination,'m' => $annonce));



    }
    public function modifierAction(Request $request)
    {


        $image = new Image();
        $image1 = new Image();
        $image2 = new Image();


        $em=$this->getDoctrine()->getManager();
        $classe = $em->getRepository('MyAppUserBundle:Annonce')->find($request->get('id'));
   

        $form=$this->createForm(AnnonceTypeModifier::class,$classe);

        if ($form->handleRequest($request)->isValid()){

            echo 'salut';


            $image->setFile($classe->getFile1());
            $image->upload();
            $image1->setFile($classe->getFile2());
            $image1->upload();
            $image2->setFile($classe->getFile3());
            $image2->upload();



            $classe->getImage()->get(0)->setUrl($image->getUrl());
            $classe->getImage()->get(1)->setUrl($image1->getUrl());
            $classe->getImage()->get(2)->setUrl($image2->getUrl());

            $em->persist($classe);

            $em->persist($image);
            $em->persist($image1);
            $em->persist($image2);

            $em->flush();
echo ' aaaaaaaaaaaaaaaaaaa';
            return $this->redirectToRoute('afficherAnnonceUser');

        }

        return $this->render('MyAppUserBundle:Annonce:modifierUneAnnonce.html.twig',array('form'=>$form->createView()));
    }


/*
    function AfficherAction(Request $req)
    {
        $offre = new Annonce();
        $form=$this->createForm(AnnonceRechercheMap::class,$offre);
        $em = $this->getDoctrine()->getManager();
        $classes = $em->getRepository('MyAppUserBundle:Annonce')->afficheAnnonce($this->getUser());
        if($form->handleRequest($req)->isValid()) {

            $classes = $em->getRepository('MyAppUserBundle:Annonce')->rechercherAnnonce();
            echo "okokokokok";


        }
        return $this->render('',array('f'=>$form->createView(),'m'=> $classes));
    }

*/
    function supprimerAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('MyAppUserBundle:Annonce')->find($req->get('id'));
        $reservation = $em->getRepository('MyAppUserBundle:Reservation')->findBy(array('idAnnonce'=>$req->get('id')));
      $image = $em->getRepository('MyAppUserBundle:Image')->findBy(array('idAnnonce'=>$req->get('id')));
        if ($reservation == null) {


            $em->remove($image[0]);
            $em->remove($image[1]);
            $em->remove($image[2]);
            $em->remove($image[3]);
            $em->remove($image[4]);
            $em->remove($image[5]);
            $em->remove($annonce);

            $em->flush();
            $this->get('ras_flash_alert.alert_reporter')->addSuccess("Votre annonce est supprimée avec succes");

        }
        else
        {
            $this->get('ras_flash_alert.alert_reporter')->addError("Cette annonce a des reservations vous ne pouvez pas la supprimer");
           return $this->redirectToRoute('afficher UserAnnonce1',array('id'=>$req->get('id')));
        }


            return $this->redirectToRoute('afficherAnnonceUser');

    }


    function rechercheAllAction(){

        $em = $this->getDoctrine()->getManager();
        $id=$this->getUser()->getId();
        $annonce = $em->getRepository('MyAppUserBundle:Annonce')->findBy(array('idUser'=>$id));


        foreach ($annonce as $r){
            $img = $images[$r->getId()]=$em->getRepository('MyAppUserBundle:Image')->findBy(array('idAnnonce'=>$r->getId()));
//            if($contact->getId()!=$id){
            $v["_".$r->getId()] = array($r->getId(), $r->getTypeMaison(),
                $r->getTypeLogement(), $r->getIdPays(),
                $r->getVille(), $r->getPrix(),
                $r->getDateDebut(),$r->getDateFin(),$img[0]->getUrl()

            );
//            }


        }
        $response = new JsonResponse();

        return $response->setData($v);
    }

    function rechercheAction($caractere){

        $em = $this->getDoctrine()->getManager();
        $id=$this->getUser()->getId();
        $annonce = $em->getRepository('MyAppUserBundle:Annonce')->findRandoByCaractere($caractere);


        foreach ($annonce as $r){
            $img = $images[$r->getId()]=$em->getRepository('MyAppUserBundle:Image')->findBy(array('idAnnonce'=>$r->getId()));
//            $da= $randonnee->getDate();
//            $result = $da->format('Y-m-d');
            $v["_".$r->getId()] = array($r->getId(), $r->getTypeMaison(),
                $r->getTypeLogement(), $r->getIdPays(),
                $r->getVille(), $r->getPrix(),
                $r->getDateDebut(),$r->getDateFin(),$img[0]->getUrl()
            );
//            }


        }
        $response = new JsonResponse();

        return $response->setData($v);
    }



    function afficherAnnoncePropositionAction(Request $request,$id_demande)
    {
        $em=$this->getDoctrine()->getManager();
        $id= $this->getUser()->getId();

        $annonce = $em->getRepository('MyAppUserBundle:Annonce')->findBy(array('idUser'=>$id));

        $dql   = "select s from  MyAppUserBundle:Annonce s where s.idUser=:y";
        $query = $em->createQuery($dql)->setParameter('y',$this->getUser());
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );

        return $this->render('', array('pagination' => $pagination,'m' => $annonce,'id_demande'=>$id_demande));



    }






}