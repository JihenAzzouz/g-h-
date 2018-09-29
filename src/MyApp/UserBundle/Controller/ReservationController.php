<?php

namespace MyApp\UserBundle\Controller;

use MyApp\UserBundle\Entity\Annonce;
use MyApp\UserBundle\Entity\Favoris;
use MyApp\UserBundle\Entity\Paiment;
use MyApp\UserBundle\Entity\Reservation;
use MyApp\UserBundle\Form\ReservationType;
use MyApp\UserBundle\Form\ReservationTypeRech;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }






    function MesReservationsAction(Request $request)
    {
        $id=$this->getUser()->getId();
       // echo $id;
        $em=$this->getDoctrine()->getManager();
        $reservations=$em->getRepository('MyAppUserBundle:Reservation')->findBy(array('idUser'=>$id));

        if($reservations != null) {
            foreach ($reservations as $r)
            {
                $images[$r->getId()]=$em->getRepository('MyAppUserBundle:Image')->findBy(array('idAnnonce'=>$r->getIdAnnonce()));
            }
        }
        else{$images = array(1);}

        $dql   = "SELECT r FROM MyAppUserBundle:Reservation r where r.idUser=:idU";

        $query = $em->createQuery($dql)->setParameter('idU',$id);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 6)/*limit per page*/
        );

        return $this->render('MyAppUserBundle:reservation:MesReservations.html.twig',array('r'=>$reservations,'pagination' => $pagination,'img'=>$images));

    }

    function rechercheAllAction(){

        $em = $this->getDoctrine()->getManager();
        $id=$this->getUser()->getId();
        $reservations=$em->getRepository('MyAppUserBundle:Annonce')->findBy(array('idUser'=>$id));



        foreach ($reservations as $r){
            $img = $images[$r->getId()]=$em->getRepository('MyAppUserBundle:Image')->findBy(array('idAnnonce'=>$r->getId()));
//            if($contact->getId()!=$id){
            $v["_".$r->getId()] = array($r->getId(), $r->getDateDebut(),
                $r->getDateFin(), $r->getAdresse(),
                $r->getBatiment(), $r->getCodePostal(),$img[0]->getUrl()
            );
//            }


        }
        $response = new JsonResponse();

        return $response->setData($v);
    }

    function rechercheAction($caractere){

        $em = $this->getDoctrine()->getManager();
        $id=$this->getUser()->getId();
        $reservation = $em->getRepository('MyAppUserBundle:Annonce')->findAnnCaractere($caractere,$id);


        foreach ($reservation as $r){
            $img = $images[$r->getId()]=$em->getRepository('MyAppUserBundle:Image')->findBy(array('idAnnonce'=>$r->getId()));
//            $da= $randonnee->getDate();
//            $result = $da->format('Y-m-d');
            $v["_".$r->getId()] = array($r->getId(), $r->getDateDebut(),
                $r->getDateFin(), $r->getAdresse(),
                $r->getBatiment(), $r->getCodePostal(),$img[0]->getUrl()
            );
//            }


        }
        $response = new JsonResponse();

        return $response->setData($v);
    }

    function ResDesVisiteursAction()
    {
        $id=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $annonces=$em->getRepository('MyAppUserBundle:Annonce')->findBy(array('idUser'=>$id));//select * from modele // esm l entite w esm l bundle
        foreach ($annonces as $a)
        {
            $images[$a->getId()]=$em->getRepository('MyAppUserBundle:Image')->findBy(array('idAnnonce'=>$a->getId()));
        }
        return $this->render('MyAppUserBundle:reservation:ReservationsDesVisiteurs.html.twig',array('a'=>$annonces,'img'=>$images));
    }

    function ReservationsDesVisiteurAccepteeAction($id,Request $req)
    {
        $reservation = new Reservation();
        $form=$this->createForm(ReservationTypeRech::class,$reservation);
        $em=$this->getDoctrine()->getManager();
        $reservations=$em->getRepository('MyAppUserBundle:Reservation')->findBy(array('etat'=>array('Acceptee','Payee'),'idAnnonce'=>$id));//select * from modele // esm l entite w esm l bundle
        $var = false;
        if($form->handleRequest($req)->isValid()) {

            $reservations = $em->getRepository('MyAppUserBundle:Reservation')->RechercheDate($reservation,$id);
            $var = true;
        }
        return $this->render('MyAppUserBundle:reservation:ReservationsDesVisiteursAcceptee.html.twig',array('r'=>$reservations,'idAnnonce'=>$id,'f'=>$form->createView(),'var'=>$var));

    }

    function ReservationsDesVisiteursATraiterAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reservations=$em->getRepository('MyAppUserBundle:Reservation')->findBy(array('etat'=>'En Attente','idAnnonce'=>$id));//select * from modele // esm l entite w esm l bundle
        return $this->render('MyAppUserBundle:reservation:ReservationsDesVisiteursATraiter.html.twig',array('r'=>$reservations,'idAnnonce'=>$id));

    }

    function AccepterReservationAction($id,$idAnnonce)
    {

        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('MyAppUserBundle:Reservation')->find($id);
        $reservation->setEtat('Acceptee');
        $user = $em->getRepository('MyAppUserBundle:User')->find($reservation->getIdUser());
       $emailUser = $user->getEmail();
        $em->persist($reservation);
        $em->flush();
        $message = \Swift_Message::newInstance()
            ->setSubject('Reservation Accpetee')
            ->setFrom('rim.triki@esprit.tn')
            ->setTo($emailUser)
            ->setBody('Votre réservation a été acceptée')

        ;
        $this->get('mailer')->send($message);
        return $this->redirectToRoute('Reservations des visiteurs a Traiter',array('id'=>$idAnnonce));

        //return $this->render('TrikiEspritBundle:Etudiant:AjouterEtudiant.html.twig', array('e'=>$form->createView()));

    }

    function RefuserReservationAction($id,$idAnnonce)
    {

        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('MyAppUserBundle:Reservation')->find($id);
        $reservation->setEtat('Refusee');
        $user = $em->getRepository('MyAppUserBundle:User')->find($reservation->getIdUser());
        $emailUser = $user->getEmail();
        $em->persist($reservation);
        $em->flush();
        $message = \Swift_Message::newInstance()
            ->setSubject('Reservation Refusee')
            ->setFrom('rim.triki@esprit.tn')
            ->setTo($emailUser)
            ->setBody('Votre réservation a été refusée')

        ;
        $this->get('mailer')->send($message);
        return $this->redirectToRoute('Reservations des visiteurs a Traiter',array('id'=>$idAnnonce));

        //return $this->render('TrikiEspritBundle:Etudiant:AjouterEtudiant.html.twig', array('e'=>$form->createView()));

    }

    function MesReservationsAPayerAction()
    {

        $id=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $reservations=$em->getRepository('MyAppUserBundle:Reservation')->findBy(array('idUser'=>$id,'etat'=>'Acceptee'));//select * from modele // esm l entite w esm l bundle
        if($reservations != null) {
            foreach ($reservations as $r) {
                $images[$r->getId()] = $em->getRepository('MyAppUserBundle:Image')->findBy(array('idAnnonce' => $r->getIdAnnonce()));
            }
        }
        else{$images = array(1);}
        return $this->render('',array('r'=>$reservations,'img'=>$images));

    }





    function AjouterFavoriesAction($id)
    {
        $msg='';
        $Favorie = new Favoris();
        $idU = $this->getUser();
        $idUs = $this->getUser()->getId();
        $Favorie->setIdUser($idU);
        $em=$this->getDoctrine()->getManager();
        $annonce = $em->getRepository('MyAppUserBundle:Annonce')->findOneBy(array('id'=>$id));
        $Favorie->setIdAnnonce($annonce);
        $fav = $em->getRepository('MyAppUserBundle:Favoris')->findOneBy(array('idAnnonce'=>$annonce->getId(),'idUser'=>$idUs));

        if($fav == null) {
            $em->persist($Favorie);
            $em->flush();
            $msg='Ajouter avec succées a votre liste de favoris';
            $this->get('ras_flash_alert.alert_reporter')->addSuccess($msg);

        }else{
            $msg='Cette annonce existe déja dans votre liste de favories';
            $this->get('ras_flash_alert.alert_reporter')->addWarning($msg);

        }

        return $this->redirectToRoute('afficher Annonce',array('id'=>$annonce->getId()));

    }

    function AfficherFavoriesAction(Request $request)
    {
        $id=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $Favories=$em->getRepository('MyAppUserBundle:Favoris')->findBy(array('idUser'=>$id));//select * from modele // esm l entite w esm l bundle
        if($Favories != null) {
            foreach ($Favories as $f) {
                $images[$f->getId()] = $em->getRepository('MyAppUserBundle:Image')->findBy(array('idAnnonce' => $f->getIdAnnonce()));
            }
        }
        else{$images = array(1);}

        $dql   = "SELECT f FROM MyAppUserBundle:Favoris f where f.idUser=:idU";
        $query = $em->createQuery($dql)->setParameter('idU',$id);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 3)/*limit per page*/
        );



        return $this->render('',array('f'=>$Favories,'pagination' => $pagination,'img'=>$images));

    }

    function SupprimerFavorieAction($id)
    {
        $fav = new Favoris();
        $fav->setId($id);
        $em=$this->getDoctrine()->getManager();//invoquer ORM
        $favorie=$em->getRepository('MyAppUserBundle:Favoris')->find($fav);
        $em->remove($favorie);
        $em->flush();
        return $this->redirectToRoute('Afficher Favories');

    }

    function rechcheckbox1Action($c1,$c2,$c3,$c4)
    {
        $em = $this->getDoctrine()->getManager();
        if($c1 != null && $c2 == null && $c3 == null && $c4 == null){
            $reservation = $em->getRepository('MyAppUserBundle:Reservation')->findBy(array('etat'=>'En Attente','idUser'=>$this->getUser()->getId()));

        }

        if($c1 != null && $c2 != null && $c3 == null && $c4 == null){
            $reservation = $em->getRepository('MyAppUserBundle:Reservation')->findBy(array('etat'=>'En Attente','idUser'=>$this->getUser()->getId()));

        }


        $v=null;

        foreach ($reservation as $r){
            $img = $images[$r->getId()]=$em->getRepository('MyAppUserBundle:Image')->findBy(array('idAnnonce'=>$r->getIdAnnonce()));
//            $da= $randonnee->getDate();
//            $result = $da->format('Y-m-d');
            $v["_".$r->getId()] = array($r->getId(), $r->getDateDebut(),
                $r->getDateFin(), $r->getEtat(),
                $r->getPrixNuite(), $r->getNbNuite(),
                $r->getPrix(),$r->getIdAnnonce()->getTypeMaison(),$img[0]->getUrl()
            );
//            }


        }
        $response = new JsonResponse();

        return $response->setData($v);
    }



}
