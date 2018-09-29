<?php

namespace MyApp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    function adminAction()
    {

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('MyAppUserBundle:User')->findAll();
        return $this->render('MyAppAdminBundle:user:lister.html.twig', array('users' => $users));
    }

    function loginAction()
    {
        return $this->render(':admin:login.html.twig');
    }
    public function SupprimerAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('laf_user_homepage');
    }
}
