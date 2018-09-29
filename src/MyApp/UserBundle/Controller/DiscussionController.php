<?php

namespace MyApp\UserBundle\Controller;

use MyApp\UserBundle\Entity\Categorie;
use MyApp\UserBundle\Entity\Discussion;
use MyApp\UserBundle\Entity\DiscussionSuivie;
use MyApp\UserBundle\Form\DiscussionType;
use MyApp\UserBundle\Form\ModifDis;
use MyApp\UserBundle\Form\ReponseType;
use MyApp\UserBundle\Entity\Reponse;
use MyApp\UserBundle\Sockets\Chat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use MyApp\UserBundle\Entity\Vues;

class DiscussionController extends Controller
{
    function getDiscussionAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $discussion = $em->getRepository('MyAppUserBundle:Discussion')->find($request->get('id'));
        $lastEntery = $em->getRepository('MyAppUserBundle:Vues')->findOneBy(array(), array('date' => 'ASC'));
        if ($lastEntery)
        {$diff = date_diff(new \DateTime('now'), $lastEntery->getDate());
            if( $diff->d > 1)
            {
                $Allvues = $em->getRepository('MyAppUserBundle:Vues')->findAll();
                foreach ($Allvues as $deletevue) {
                    $em->remove($deletevue);
                }
                $em->flush();
            }
        }
        $ip = $request->getClientIp();
        $testvue = $em->getRepository('MyAppUserBundle:Vues')->findOneBy(array('discussion' => $discussion, 'ipUuser' => $ip));
        if(!$testvue)
        {
            $discussion->setNbvues($discussion->getNbvues()+1);
            $em->persist($discussion);
            $vue = new Vues();
            $vue->setIpUuser($ip);
            $vue->setDiscussion($discussion);
            $vue->setDate(new \DateTime('now'));
            $em->persist($vue);
           $em->flush();
        }
        return $discussion;
    }

    function newDiscussionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $discussion = new Discussion();
        $formDis = $this->createForm(DiscussionType::class, $discussion);
        if ($request->get('id')) {
            $categorie = $em->getRepository('MyAppUserBundle:Categorie')->find($request->get('id'));
            $discussion->setIdCategorie($categorie);
        }
        if ($this->container->get('security.token_storage')->getToken()->getUser() != 'anon.')
        {
            $discussion->setNbrep(0);
            $discussion->setNblikes(0);
            $discussion->setLastRep(null);
            $discussion->setDatepost(new \DateTime('now'));
            $discussion->setIdUser($this->container->get('security.token_storage')->getToken()->getUser());
            $discussion->setNbvues(0);
            $discussion->setOpen(true);
            $discussion->setEdited(false);
            $discussion->setDatelastrep(new \DateTime('now'));
            if ($formDis->handleRequest($request)->isValid()) {
                $categorie->setLastmodifdis($discussion);
                $categorie->setNbdiss($categorie->getNbdiss() + 1);
                $em->persist($categorie);
                $em->persist($discussion);
                $em->flush();
                return $this->redirect($this->generateUrl('discussion', array('id' => $discussion->getId())));
            }
        }
        return $this->render('MyAppUserBundle:forum:newTopic.html.twig',array('f'=> $formDis->createView(), 'categorie' => $categorie));
    }

    function RechercheAJAXAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $qb = $em->createQueryBuilder();
            $qb->select('d')
                ->from('MyAppUserBundle:Discussion', 'd')
                ->where('upper(d.titre) like upper(:titre)')->setParameter('titre', '%'.$request->request->get('titre').'%');
            $data = $qb->getQuery()->getArrayResult();
            $response = new JsonResponse();
            return $response->setData($data);
        } else {
            throw new Exception("Erreur");
        }
    }
    function deleteDisAJAXAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $rep = $em->getRepository('MyAppUserBundle:Reponse')->find($request->request->get('id'));
            $em->remove($rep);
            $em->flush();
            $dis= $em->getRepository('MyAppUserBundle:Discussion')->find($rep->getIdDiscussion());
            $cat = $em->getRepository('MyAppUserBundle:Categorie')->find($dis->getIdCategorie());
            $dis->setNbrep($dis->getNbrep()-1);
            $cat->setNbmsg($cat->getNbmsg()-1);
            $lastrep = $em->getRepository('MyAppUserBundle:Reponse')->findBy(array('idDiscussion'=>$dis->getId()), array('datepost' => 'DESC'));
            if (empty($lastrep))
            {
               $dis->setLastRep(null);
            }
            else {
                $dis->setLastRep($lastrep[0]);
            }
            $em->persist($dis,$cat);
            $em->flush();
            $response = new JsonResponse('done');
            return $response;
        } else {
            throw new Exception("Erreur");
        }
    }

    function viewDiscussionAction(Request $request)
    {
        $rated = null;
        $likeddis = null;
        $em=$this->getDoctrine()->getManager();
        $categories = $em->getRepository('MyAppUserBundle:Categorie')->findAll();
        $users = $this->getDoctrine()->getManager()->getRepository('MyAppUserBundle:User')->getActive();
        $discussions = $em->getRepository('MyAppUserBundle:Discussion')->findAll();
        $reponses = $em->getRepository('MyAppUserBundle:Reponse')->findAll();
        $utilisateurs = $em->getRepository('MyAppUserBundle:User')->findAll();
        $discussion = $this->getDiscussionAction($request);
        $rep = new Reponse();
        $rep->setIdDiscussion($discussion);
        $rep->setEdited(false);
        $rep->setRate(0);
        $rep->setDatepost(new \DateTime('now'));
        $rep->setDatelastedit(new \DateTime('now'));
        $rep->setTitre('Re: '.$discussion->getTitre());
        $formRep = $this->createForm(ReponseType::class, $rep);
        $categorie = $em->getRepository('MyAppUserBundle:Categorie')->find($discussion->getIdCategorie());
        if ($this->container->get('security.token_storage')->getToken()->getUser() != 'anon.')
        {
            $likeddis = $em->getRepository('MyAppUserBundle:DiscussionSuivie')->findby(array('iduser' =>
            $this->container->get('security.token_storage')->getToken()->getUser(), 'iddis' => $discussion->getid()));
            $qb = $em->createQueryBuilder();
            $qb->select('d')
                ->from('MyAppUserBundle:DiscussionSuivie', 'd')
                ->where(' d.iduser =:user')
                ->andWhere('d.nature != :nature')
                ->setParameters(array('user' => $this->container->get('security.token_storage')->getToken()->getUser()
                , 'nature' => 'discussion'));
            $rated = $qb->getQuery()
                ->getResult();
            $rep->setIdUser($this->container->get('security.token_storage')->getToken()->getUser());

            if($formRep->handleRequest($request)->isValid())
            {
                $discussion->setLastRep($rep);
                $discussion->setNbrep($discussion->getNbrep()+1);
                $categorie->setNbmsg($categorie->getNbmsg()+1);
                $categorie->setLastmodifdis($discussion);
                $em->persist($discussion);
                $em->persist($categorie);
                $em->persist($rep);
                $em->flush();
                return $this->redirect($this->generateUrl('discussion', array('id' => $discussion->getId(), 'idR'=>$rep->getId())));
            }
        }

        $dql   = "SELECT r FROM MyAppUserBundle:Reponse r where r.idDiscussion=:dis order by r.datepost";
        $query = $em->createQuery($dql)->setParameter('dis',$discussion);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        if ($request->get('idR'))
        {
            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', $pagination->getPageCount())/*page number*/,
                5/*limit per page*/
            );
        }
        return $this->render('MyAppUserBundle:forum:topic.html.twig',
            array('discussion' =>$discussion,'pagination'=>$pagination,'users'=>$users,
                'dis'=>$discussions, 'rep' => $reponses , 'utlisateurs' =>$utilisateurs, 'categories'=>$categories,
                'f'=> $formRep->createView(), 'numPage' =>$request->get('page') == 1 , 'rated' => $rated, 'aime' => $likeddis));

    }

    function deleteDisAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $dis = $em->getRepository('MyAppUserBundle:Discussion')->find($request->get('id'));
        $em->remove($dis);
        $em->flush();
        $cat = $em->getRepository('MyAppUserBundle:Categorie')->find($request->get('idCat'));
        $lastdis = $em->getRepository('MyAppUserBundle:Discussion')->findBy(array('idCategorie'=>$cat->getId()), array('datelastrep' => 'DESC'));
        if (empty($lastdis))
        {
            $cat->setLastmodifdis(null);
        }
        else {
        $cat->setLastmodifdis($lastdis[0]);
        }
        $cat->setNbdiss($cat->getNbdiss()-1);
        $cat->setNbmsg($cat->getNbmsg()-$dis->getNbrep());
        $em->persist($cat);
        $em->flush();
        return $this->redirect($this->generateUrl('categorie', array('id' =>$request->get('idCat'))));
    }

    function newRepAction(Request $request)
    {
        $rep = new Reponse();
        $rep->setEdited(false);
        $rep->setRate(0);
        $rep->setDatepost(new \DateTime('now'));
        $rep->setDatelastedit(new \DateTime('now'));
        $em = $em=$this->getDoctrine()->getManager();
        $dis = $em->getRepository('MyAppUserBundle:Discussion')->find($request->get('idD'));
        $categorie = $em->getRepository('MyAppUserBundle:Categorie')->find($dis->getIdCategorie());
        $rep->setTitre('Re: '.$dis->getTitre());
        $rep->setIdDiscussion($dis);
        $formrep = $this->createForm(ReponseType::class, $rep);
        $rep->setIdUser($this->container->get('security.token_storage')->getToken()->getUser());
        if($formrep->handleRequest($request)->isValid())
        {
            $dis->setLastRep($rep);
            $dis->setNbrep($dis->getNbrep()+1);
            $categorie->setNbmsg($categorie->getNbmsg()+1);
            $categorie->setLastmodifdis($dis);
            $em->persist($dis);
            $em->persist($categorie);
            $em->persist($rep);
            $em->flush();
            return $this->redirect($this->generateUrl('discussion', array('id' => $dis->getId(), 'idR'=>$rep->getId())));
        }
        return $this->render('MyAppUserBundle:forum:newReponse.html.twig',
            array('discussion' => $rep->getIdDiscussion(), 'f'=>$formrep->createView() ));
    }

    function upRepAJAXAction(Request $req)
    {
        $em=$this->getDoctrine()->getManager();

        if ($req->isXmlHttpRequest()) {
            $rep = $em->getRepository('MyAppUserBundle:Reponse')->find($req->request->get('id'));
            $rating = new DiscussionSuivie();
            $rating->setIdrep($rep);
            $rating->setIduser($this->container->get('security.token_storage')->getToken()->getUser());
            $rating->setNature('like');
            $rep->setRate($rep->getRate()+1);
            $em->persist($rep);
            $em->persist($rating);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData($rep->getRate());
        } else {
            throw new Exception("Erreur");
        }
    }

    function downRepAJAXAction(Request $req)
    {
        $em=$this->getDoctrine()->getManager();

        if ($req->isXmlHttpRequest()) {
            $rep = $em->getRepository('MyAppUserBundle:Reponse')->find($req->request->get('id'));
            $rating = new DiscussionSuivie();
            $rating->setIdrep($rep);
            $rating->setIduser($this->container->get('security.token_storage')->getToken()->getUser());
            $rating->setNature('dislike');
            $rep->setRate($rep->getRate()-1);
            $em->persist($rep);
            $em->persist($rating);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData($rep->getRate());
        } else {
            throw new Exception("Erreur");
        }
    }

    function ModifRepAction(Request $req)
    {
        $em=$this->getDoctrine()->getManager();
        $rep =  $em->getRepository('MyAppUserBundle:Reponse')->find($req->get('idReponse'));
        $form = $this->createForm(ReponseType::class, $rep);
        if ($form->handleRequest($req)->isValid())
        {
            $rep->setEdited(true);
            $rep->setDatelastedit(new \DateTime('now'));
            $em->persist($rep);
            $em->flush();
            return $this->redirect($this->generateUrl('discussion', array('id' => $rep->getIdDiscussion()->getId(), 'idR'=>$rep->getId())));
        }
        return $this->render('MyAppUserBundle:forum:modifierReponse.html.twig',
        array('discussion' => $rep->getIdDiscussion(), 'f'=>$form->createView() ));

    }

    function ModifDisAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $dis =  $em->getRepository('MyAppUserBundle:Discussion')->find($request->get('idDiscussion'));
        $form = $this->createForm(ModifDis::class, $dis);
        if ($form->handleRequest($request)->isValid())
        {
            $dis->setEdited(true);
            $dis->setDateladtmodif(new \DateTime('now'));
            $em->persist($dis);
            $em->flush();
            return $this->redirect($this->generateUrl('discussion', array('id' => $dis->getId())));
        }
        return $this->render('MyAppUserBundle:forum:modifierDiscussion.html.twig',array('f'=> $form->createView(),
            'categorie' => $dis->getIdCategorie()));
    }

    function citerRepAction(Request $request)
    {
        $rep = new Reponse();
        $rep->setEdited(false);
        $rep->setRate(0);
        $rep->setDatepost(new \DateTime('now'));
        $rep->setDatelastedit(new \DateTime('now'));
        $em = $em=$this->getDoctrine()->getManager();
        $repcite = $em->getRepository('MyAppUserBundle:Reponse')->find($request->get('idReponse'));
        $dis = $em->getRepository('MyAppUserBundle:Discussion')->find($request->get('idD'));
        $categorie = $em->getRepository('MyAppUserBundle:Categorie')->find($dis->getIdCategorie());
        $rep->setTitre('Re: '.$dis->getTitre());
        $rep->setIdDiscussion($dis);
        $formrep = $this->createForm(ReponseType::class, $rep);
        $rep->setIdUser($this->container->get('security.token_storage')->getToken()->getUser());
        if($formrep->handleRequest($request)->isValid())
        {
            $rep->setContenu('<blockquote >
                                        <span class="original" style="font-size: 16px;color:#0a7280">'
                .$repcite->getIdUser().' a dit :</span>
                                        <span style="font-size: 16px">'.$repcite->getContenu().'</span>
                                    </blockquote>'.$rep->getContenu());
            $dis->setLastRep($rep);
            $dis->setNbrep($dis->getNbrep()+1);
            $categorie->setNbmsg($categorie->getNbmsg()+1);
            $categorie->setLastmodifdis($dis);
            $em->persist($dis);
            $em->persist($categorie);
            $em->persist($rep);
            $em->flush();
            return $this->redirect($this->generateUrl('discussion', array('id' => $dis->getId(), 'idR'=>$rep->getId())));
        }
        return $this->render('MyAppUserBundle:forum:citerRep.html.twig',
            array('discussion' => $rep->getIdDiscussion(), 'f'=>$formrep->createView(), 'repc' => $repcite));
    }

    function likeDisAJAXAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $dis = $em->getRepository('MyAppUserBundle:Discussion')->find($request->request->get('id'));
            $rating = new DiscussionSuivie();
            $rating->setIddis($dis);
            $rating->setIduser($this->container->get('security.token_storage')->getToken()->getUser());
            $rating->setNature('discussion');
            $dis->setNblikes($dis->getNblikes()+1);
            $em->persist($dis);
            $em->persist($rating);
            $em->flush();
            $response = new JsonResponse();
            return $response;
        } else {
            throw new Exception("Erreur");
        }
    }

    function chatAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository('MyAppUserBundle:User')->find($request->get('id'));
        $user->setBannForum(true);
        $em->persist($user);
        $em->flush();
        $chatusers = $em->getRepository('MyAppUserBundle:User')->findBy(array('bannForum' => true));
        $users = $this->getDoctrine()->getManager()->getRepository('MyAppUserBundle:User')->getActive();
        return $this->render('MyAppUserBundle:forum:ChatRoomForum.html.twig', array(
            'user'=>$user,
            'users' => $chatusers,
            'online' =>$users
        ));
    }

    function ExitchatAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository('MyAppUserBundle:User')->find($request->get('id'));
        $user->setBannForum(false);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('my_app_user_forumIndex');
    }

    function SearchFAction(Request $request)
    {
        $paginator  = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $users = $this->getDoctrine()->getManager()->getRepository('MyAppUserBundle:User')->getActive();
        $motcle = $request->get('search');
        $dql   = "SELECT r FROM MyAppUserBundle:Reponse r where r.contenu like :motcle ";
        $query = $em->createQuery($dql)->setParameter('motcle','%'.$motcle.'%');
        $paginationrep = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        $dql2   = "SELECT d FROM MyAppUserBundle:Discussion d where d.titre like :motcle ";
        $query = $em->createQuery($dql2)->setParameter('motcle','%'.$motcle.'%');
        $paginationdis = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('',
        array(
            'reponses' => $paginationrep,
            'discussions' => $paginationdis,
            'users' => $users
        ));
    }
}
