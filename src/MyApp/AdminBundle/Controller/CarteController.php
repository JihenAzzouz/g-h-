<?php

namespace MyApp\AdminBundle\Controller;

use MyApp\UserBundle\Entity\Carte;
use MyApp\UserBundle\Form\AjoutCarteType;
use MyApp\UserBundle\Form\CarteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class CarteController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    function GenererCarteAction(Request $request)
    {

        $carte = new Carte();
        $form = $this->createForm(CarteType::class, $carte);

        $carte->setCode(random_int(10000001, 99999999));
        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($carte);
            $em->flush();
            //  return $this->redirectToRoute('AfficherCarte');
        }
        return $this->render('MyAppAdminBundle:carte:essai.html.twig', array('form' => $form->createView()));

    }

    function afficherCarteAction(Request $req)
    {

        $carte = new Carte();
        $form = $this->createForm(CarteType::class, $carte);

        $carte->setCode(random_int(00000001, 99999999));
        if ($form->handleRequest($req)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($carte);
            $em->flush();
            //  return $this->redirectToRoute('AfficherCarte');
        }
        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository('MyAppUserBundle:Carte')->findAll();//select * from modele // esm l entite w esm l bundle

        return $this->render('MyAppAdminBundle:carte:GenererCarte.html.twig', array('c' => $cartes, 'form' => $form->createView()));

    }

    function supprimerCarteAction($id)
    {

        $em = $this->getDoctrine()->getManager();//invoquer ORM
        $model = $em->getRepository('MyAppUserBundle:Carte')->find($id);
        $em->remove($model);
        $em->flush();
        return $this->redirectToRoute('AfficherCarte');
    }

    function deleteDisAJAXAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $model = $em->getRepository('MyAppUserBundle:Carte')->find($request->request->get('id'));
            $em->remove($model);
            $em->flush();
            $response = new JsonResponse('done');
            return $response;
        } else {
            throw new Exception("Erreur");
        }
    }




}
