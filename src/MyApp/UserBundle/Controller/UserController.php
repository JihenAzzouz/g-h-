<?php

namespace MyApp\UserBundle\Controller;

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

class UserController extends Controller
{
    function testAction()
    {
        $offre = new Annonce();

        $form=$this->createForm(AnnonceRechercheTypeForm::class,$offre , array(
            'action'=>$this->generateUrl('afficher image')
        ));
        return $this->render('::base.html.twig',array('f'=>$form->createView()));
    }

}
