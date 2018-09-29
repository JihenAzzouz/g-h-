<?php

namespace MyApp\UserBundle\Controller;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use MyApp\UserBundle\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\UserBundle\Entity\Categorie;
use MyApp\UserBundle\Entity\User;
use MyApp\UserBundle\Entity\Reponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ForumController extends Controller
{
    function getAllCategorieAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie = new Categorie();
        $formcat = $this->createForm(CategorieType::class,$categorie);
        if  ($formcat->handleRequest($request)->isValid()){
                $categorie->setNbdiss(0);
                $categorie->setNbmsg(0);
                $categorie->setLastmodifdis(null);
                $em->persist($categorie);
                $em->flush();
        }
        $users = $this->getDoctrine()->getManager()->getRepository('MyAppUserBundle:User')->getActive();
        $discussions = $em->getRepository('MyAppUserBundle:Discussion')->findAll();
        $reponses = $em->getRepository('MyAppUserBundle:Reponse')->findAll();
        $categories=$em->getRepository('MyAppUserBundle:Categorie')->findAll();
        $utilisateurs = $em->getRepository('MyAppUserBundle:User')->findAll();
        return $this->render('MyAppUserBundle:forum:indexForum.html.twig', array('c'=>$categories,'users' => $users,
            'dis'=>$discussions, 'rep' => $reponses , 'utlisateurs' =>$utilisateurs, 'f' =>$formcat->createView(),
        ));
    }

    function editCategorieAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $users = $this->getDoctrine()->getManager()->getRepository('MyAppUserBundle:User')->getActive();
        $discussions = $em->getRepository('MyAppUserBundle:Discussion')->findAll();
        $reponses = $em->getRepository('MyAppUserBundle:Reponse')->findAll();
        $utilisateurs = $em->getRepository('MyAppUserBundle:User')->findAll();
        $categorie = $em->getRepository('MyAppUserBundle:Categorie')->find($request->get('id'));
        $formM = $this->createForm(CategorieType::class,$categorie);
        if  ($formM->handleRequest($request)->isValid()){
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('my_app_user_forumIndex');
        }
        return $this->render('MyAppUserBundle:forum:Modif.html.twig', array(
            'fm' => $formM->createView(),'users' => $users,
            'dis'=>$discussions, 'rep' => $reponses , 'utlisateurs' =>$utilisateurs
        ));
    }

    function getCategorieAction(Request $request)
    {
        $paginator  = $this->get('knp_paginator');
        $em=$this->getDoctrine()->getManager();
        $users = $this->getDoctrine()->getManager()->getRepository('MyAppUserBundle:User')->getActive();
        $discussions = $em->getRepository('MyAppUserBundle:Discussion')->findAll();
        $reponses = $em->getRepository('MyAppUserBundle:Reponse')->findAll();
        $categorie = $em->getRepository('MyAppUserBundle:Categorie')->find($request->get('id'));
        $utilisateurs = $em->getRepository('MyAppUserBundle:User')->findAll();
        $categories = $em->getRepository('MyAppUserBundle:Categorie')->findAll();
        if ($request->get('trie'))
        {
            $range = $request->get('range');
            $selon = $request->get('order');
            $order = $request->get('direction');
            $nb = $request->get('nbitem');
            if ( $range == 'all')
            {
                $qb = $em->createQueryBuilder();
                $qb->select('d')
                    ->from('MyAppUserBundle:Discussion', 'd')
                    ->where(' d.idCategorie =:cat')
                    ->orderBy($selon,$order)->setParameters(array('cat' => $categorie->getId()));
                $pagination = $paginator->paginate(
                    $qb->getQuery(), /* query NOT result */
                    $request->query->getInt('page', 1)/*page number*/,
                    $nb/*limit per page*/
                );
                return $this->render('MyAppUserBundle:forum:categorie.html.twig', array('pagination' => $pagination,
                    'categorie'=>$categorie,'categories'=>$categories, 'users' => $users,
                    'dis'=>$discussions, 'rep' => $reponses , 'utlisateurs' =>$utilisateurs));
            }
            else {
            $qb = $em->createQueryBuilder();
            $qb->select('d')
                ->from('MyAppUserBundle:Discussion', 'd')
                ->where(' d.idCategorie =:cat')
                ->andWhere('DATE_DIFF(CURRENT_DATE(), d.datepost) < :range')
                ->orderBy($selon,$order)->setParameters(array('cat' => $categorie->getId(), 'range' => $range));

            $pagination = $paginator->paginate(
                $qb->getQuery(), /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $nb/*limit per page*/
            );
            return $this->render('MyAppUserBundle:forum:categorie.html.twig', array('pagination' => $pagination,
                'categorie'=>$categorie,'categories'=>$categories, 'users' => $users,
                'dis'=>$discussions, 'rep' => $reponses , 'utlisateurs' =>$utilisateurs));
            }
        }
        $dql   = "SELECT d FROM MyAppUserBundle:Discussion d where d.idCategorie=:cat order by d.datepost DESC";
        $query = $em->createQuery($dql)->setParameter('cat',$categorie->getId());
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return $this->render('MyAppUserBundle:forum:categorie.html.twig', array('pagination' => $pagination,
            'categorie'=>$categorie,'categories'=>$categories, 'users' => $users,
            'dis'=>$discussions, 'rep' => $reponses , 'utlisateurs' =>$utilisateurs));
    }

    public function deleteCatAJAXAction(Request $request)
    {
            $em=$this->getDoctrine()->getManager();
            if ($request->isXmlHttpRequest()) {
                $cat = $em->getRepository('MyAppUserBundle:Categorie')->find($request->get('id'));
                $em->remove($cat);
                $em->flush();
                $response = new JsonResponse('done');
                return $response;
            } else {
            throw new Exception("Erreur");
            }
    }
}
