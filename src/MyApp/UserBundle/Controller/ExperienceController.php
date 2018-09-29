<?php
/**
 * Created by PhpStorm.
 * User: MohamedKhyari
 * Date: 15/03/2017
 * Time: 02:12
 */

namespace MyApp\UserBundle\Controller;

use MyApp\UserBundle\Entity\Experience;
use MyApp\UserBundle\Entity\Image;
use MyApp\UserBundle\Entity\Video;
use MyApp\UserBundle\Form\ExperienceType;
use MyApp\UserBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Common\Collections\ArrayCollection;


class ExperienceController extends Controller
{
    public function experiencesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('MyAppUserBundle:Experience')->NombreDeExpressionParContinent();

        foreach ($e as $item) {

            $nbexp [$item["nom"]] = $item["nb"];
        }
        //dump($nbexp);die();
        return $this->render('MyAppUserBundle:experience:experiences.html.twig', array('e' => $nbexp
        ));
    }

    public function experienceAction($id, $idc)
    {
        $em = $this->getDoctrine()->getManager();
        $experience = $em->getRepository('MyAppUserBundle:Experience')->findOneBy(
            array('id' => $id));
        $co = $em->getRepository('MyAppUserBundle:Continent')->findOneBy(
            array('id' => $idc));
        return $this->render('MyAppUserBundle:experience:UneExperience.html.twig', array('v' => $experience, 'c' => $co));
    }

    public function experienceUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $experience = $em->getRepository('MyAppUserBundle:Experience')->findOneBy(
            array('id' => $id));

        $co = $em->getRepository('MyAppUserBundle:Continent')->findOneBy(
            array('id' => $experience->getIdPays()->getIdContinent()));
        return $this->render('MyAppUserBundle:experience:UneExperience.html.twig', array('v' => $experience, 'c' => $co));
    }

    public function ajouterExperienceAction(Request $req)
    {
        if ($this->get('security.token_storage')->getToken()->getRoles() == NULL) {
            $this->get('ras_flash_alert.alert_reporter')->addError("Access denied");
            return ($this->redirectToRoute('fos_user_security_login'));
        }
        $experience = new Experience();
        $image = new Image();
        $image1 = new Image();
        $image2 = new Image();
        $image3 = new Image();
        $video = new Video();
        $form = $this->createForm(ExperienceType::class, $experience);
        if ($form->handleRequest($req)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $image->setFile($experience->getFile());
            $image->upload();
            $image1->setFile($experience->getFile3());
            $image1->upload();
            $user = $this->getUser();
            $experience->setIdUser($user);
            $image2->setFile($experience->getFile1());
            $image2->upload();
            $image3->setFile($experience->getFile2());
            $image3->upload();
            $video->setFile($experience->getFile4());
            $video->upload();
            $experience->getImages()->add($image->setIdExperience($experience));
            $experience->getImages()->add($image1->setIdExperience($experience));
            $experience->getImages()->add($image2->setIdExperience($experience));
            $experience->getImages()->add($image3->setIdExperience($experience));
            //$req->getSession()->getId();
            $experience->getVideos()->add($video->setIdExperience($experience));
            $em->persist($experience);
            $em->flush();
            return $this->redirectToRoute('guestandhost_experiences');
        }
        return $this->render('MyAppUserBundle:experience:ajouterExperiences.html.twig', array('ff' => $form->createView()));
    }

    public function afficherContinentExperienceAction($id)
    {
        $form = $this->createForm(RechercheType::class);
        $em = $this->getDoctrine()->getManager();
        $experience = $em->getRepository('MyAppUserBundle:Experience')->findExperienceByContinent($id);
        //   dump($experience);die();
        //   foreach ($experience as $advert) {
        //       $listImages = $em->getRepository('MyAppUserBundle:Image')->findBy(
        //           array('idExperience' => $advert->getId())
        //       );
        //       foreach ($listImages as $img) {
        //           $advert->addImage($img);
        //       }
        //   }
        $cont = $em->getRepository('MyAppUserBundle:Continent')->find($id);

		return $this->render('MyAppUserBundle:experience:AffichageExperiences.html.twig', array('v' => $experience, 'c' => $cont, 'fo' => $form->createView()));
    }
    public function afficherContinentExperienceJsonAction($id,Request $request)
    {
        if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $experiences = $em->getRepository('MyAppUserBundle:Experience')->findExperienceByContinent($id);
        $e = null;
        foreach ($experiences as $experience) {
            $lm = $em->getRepository('MyAppUserBundle:Image')->findBy(array('idExperience' => $experience));
            foreach ($lm as $img) {
                $limg []= $img->getUrl();
            }
            $e[$experience->getId()] = array($experience->getTitre(),
                $experience->getId(),
                $experience->getDescription(),
                $limg,
                $experience->getIdPays()->getLibelle(),
                $experience->getIdVille()->getLibelleVille(),
                $experience->getIdUser()->getId()

            );
            $limg = null;
        }
        $response = new JsonResponse();
        return $response->setData($e);
    } else {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
    }
}

    function afficherUserExperienceAction()
    {
        $form = $this->createForm(RechercheType::class);
        if ($this->get('security.token_storage')->getToken()->getRoles() == NULL) {
            $this->get('ras_flash_alert.alert_reporter')->addError("Access denied");
            return ($this->redirectToRoute('fos_user_security_login'));
        }
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $experience = $em->getRepository('MyAppUserBundle:Experience')->findByidUser(array('idUser' => $user));
        return $this->render('MyAppUserBundle:experience:AffichageUserExperience.html.twig', array('v' => $experience, 'fo' => $form->createView()));
    }

    function supprimerExperienceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $experience = $em->getRepository('MyAppUserBundle:Experience')->find($id);
        if ($user->getId() !=  $experience->getIdUser()->getId())
        {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }
        $em->remove($experience);
        $em->flush();
        return $this->redirectToRoute('experiences_affichage');
    }

    function modifierExperienceAction($id, Request $req)
    {
        $image = new Image();
        $image1 = new Image();
        $image2 = new Image();
        $image3 = new Image();
        $video = new Video();
        if ($this->get('security.token_storage')->getToken()->getRoles() == NULL) {
            $this->get('ras_flash_alert.alert_reporter')->addError("Access denied");
            return ($this->redirectToRoute('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $experience = $em->getRepository('MyAppUserBundle:Experience')->find($id);
        $user = $this->getUser();
        if ($user->getId() !=  $experience->getIdUser()->getId())
        {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }

            $form = $this->createForm(ExperienceType::class, $experience, ['attr' => ['enctype' => 'multipart/form-data']]);
//dump($experience);die();


        if ($form->handleRequest($req)->isValid()) {
            // die($experience->getImages());

            $image->setFile($experience->getFile());
            $image->upload();
            $image1->setFile($experience->getFile1());
            $image1->upload();
            $image2->setFile($experience->getFile2());
            $image2->upload();
            $image3->setFile($experience->getFile3());
            $image3->upload();
            $video->setFile($experience->getFile4());

            $video->upload();
       //     dump($experience->getFile4());die;
            $experience->getImages()->get(0)->setUrl($image->getUrl());
            $experience->getImages()->get(1)->setUrl($image1->getUrl());
            $experience->getImages()->get(2)->setUrl($image2->getUrl());
            $experience->getImages()->get(3)->setUrl($image3->getUrl());
            $experience->getVideos()->get(0)->setUrl($video->getUrl());
            $em->persist($experience);
            $em->flush();

            return $this->redirectToRoute('experiences_affichage');
        }
        return $this->render('MyAppUserBundle:experience:modifierExperiences.html.twig',
            array('ff' => $form->createView(), 'img' => $experience->getImages()));
    }

    public function villesAction(Request $request, $idPays)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $villes = $em->getRepository('MyAppUserBundle:Ville')->findByidPays($idPays);

            foreach ($villes as $ville) {
                $v[$ville->getId()] = array($ville->getLibelleVille(), $ville->getId());
            }
            $response = new JsonResponse();
            return $response->setData($v);

        } else {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }
    }

    public function paysAction(Request $request, $idContinent)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $pays = $em->getRepository('MyAppUserBundle:Pays')->findByidContinent($idContinent);

            foreach ($pays as $pa) {
                $p[$pa->getId()] = array($pa->getLibelle(), $pa->getId());
            }
            $response = new JsonResponse();
            return $response->setData($p);
        } else {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }
    }

    public function paysChartAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $pays = $em->getRepository('MyAppUserBundle:Pays')->findAll();
            foreach ($pays as $pa) {
                $p[$pa->getId()] = array($pa->getLibelle(), $pa->getId());
            }
            $response = new JsonResponse();
            return $response->setData($p);
        } else {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }
    }

    public function rechercheExperienceAction(Request $request,$nom, $cont)
    {
        if ($request->isXmlHttpRequest()) {

        $em = $this->getDoctrine()->getManager();
        $experiences = $em->getRepository('MyAppUserBundle:Experience')->ExpressionParContinentNom($nom, $cont);

        $e = null;
        foreach ($experiences as $experience) {
            $lm = $em->getRepository('MyAppUserBundle:Image')->findBy(array('idExperience' => $experience));

            foreach ($lm as $img) {
                $limg []= $img->getUrl();
            }
            $e[$experience->getId()] = array($experience->getTitre(),
                $experience->getId(),
                $experience->getDescription(),
                $limg,
                $experience->getIdPays()->getLibelle(),
                $experience->getIdVille()->getLibelleVille(),
                $experience->getIdUser()->getId()

            );
            $limg = null;
        }

        $response = new JsonResponse();
        return $response->setData($e);
        } else {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }

    }

    public function rechercheExperienceParPaysAction(Request $request,$idPays)
    { if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $experiences = $em->getRepository('MyAppUserBundle:Experience')->findBy(array('idPays' => $idPays));
        $e = null;
        foreach ($experiences as $experience) {
            $lm = $em->getRepository('MyAppUserBundle:Image')->findBy(array('idExperience' => $experience));
            foreach ($lm as $img) {
                $limg []= $img->getUrl();
            }
            $e[$experience->getId()] = array($experience->getTitre(),
                $experience->getId(),
                $experience->getDescription(),
                $limg,
                $experience->getIdPays()->getLibelle(),
                $experience->getIdVille()->getLibelleVille(),
                $experience->getIdUser()->getId()

            );
            $limg = null;
        }
        $response = new JsonResponse();
     //   dump($e);die();
        return $response->setData($e);
    } else {
        throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
    }
    }

    public function rechercheExperienceParVilleAction(Request $request,$idVille)
    {if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $experiences = $em->getRepository('MyAppUserBundle:Experience')->findBy(array('idVille' => $idVille));
        $e = null;
        foreach ($experiences as $experience) {
            $lm = $em->getRepository('MyAppUserBundle:Image')->findBy(array('idExperience' => $experience));
            foreach ($lm as $img) {
                $limg[] = $img->getUrl();
            }
            $e[$experience->getId()] = array($experience->getTitre(),
                $experience->getId(),
                $experience->getDescription(),
                $limg,
                $experience->getIdPays()->getLibelle(),
                $experience->getIdVille()->getLibelleVille(),
                 $experience->getIdUser()->getId()

            );
            $limg = null;
        }
        $response = new JsonResponse();
        return $response->setData($e);
    } else {
        throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
    }
    }

        function afficherUserJsonExperienceAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository('MyAppUserBundle:User')->find($id);
        $experiences = $em->getRepository('MyAppUserBundle:Experience')->findByidUser(array('idUser' => $user));
         $e = null;
        foreach ($experiences as $experience) {
            $e[]=array(
                'id'=>$experience->getId(),
                'titre'=>$experience->getTitre(),
                'Description'=>$experience->getDescription(),
                'Pays'=>$experience->getIdPays()->getLibelle(),
                'Ville'=>$experience->getIdVille()->getLibelleVille(),
                'img'=>$experience->getImages()[0]->getUrl(),
                'IdUser'=>$experience->getIdUser()->getId(),
              //  'Video'=>$experience->getVideos()[0]->getUrl(),
            );
            $limg = null;
        }
        $response = new JsonResponse();
        return $response->setData($e);
    }
        function supprimerMobileExperienceAction($id)
    {
        $e=true;
        $em = $this->getDoctrine()->getManager();
      //  $user = $this->getUser();
        $experience = $em->getRepository('MyAppUserBundle:Experience')->find($id);
        //if ($user->getId() !=  $experience->getIdUser()->getId())
        //{
       //     throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        //}

        $em->remove($experience);
        $em->flush();
        $response = new JsonResponse();
        return $response->setData($e);

    }
    public function ajouterExperienceMobilAction(Request $req,$id)
    {
        $experience = new Experience();
        $image = new Image();
        $image1 = new Image();
        $image2 = new Image();
        $image3 = new Image();
        $video = new Video();
        $form = $this->createForm(ExperienceType::class, $experience);
        if ($form->handleRequest($req)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $image->setFile($experience->getFile());
            $image->upload();
            $image1->setFile($experience->getFile3());
            $image1->upload();
            $user=$em->getRepository('MyAppUserBundle:User')->find($id);
            $experience->setIdUser($user);
            $image2->setFile($experience->getFile1());
            $image2->upload();
            $image3->setFile($experience->getFile2());
            $image3->upload();
            $video->setFile($experience->getFile4());
            $video->upload();
            $experience->getImages()->add($image->setIdExperience($experience));
            $experience->getImages()->add($image1->setIdExperience($experience));
            $experience->getImages()->add($image2->setIdExperience($experience));
            $experience->getImages()->add($image3->setIdExperience($experience));
            //$req->getSession()->getId();
            $experience->getVideos()->add($video->setIdExperience($experience));
            $em->persist($experience);
            $em->flush();
            $e=true;
            $response = new JsonResponse();
            return $response->setData($e);
        }
        return $this->render('MyAppUserBundle:experience:ajouterExperiences.html.twig', array('ff' => $form->createView()));
    }
    function JsonExperienceImageAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $experience=$em->getRepository('MyAppUserBundle:Experience')->find($id);
        $e = null;
        $images = $em->getRepository('MyAppUserBundle:Image')->findBy(array('idExperience' => $experience->getId()));
            foreach ($images as $img) {
                $e[] = array(
                    'id'=>$img->getId(),
                    'idExperience'=>$img->getIdExperience()->getId(),
                    'url'=>$img->getUrl()
                );
            }

        $response = new JsonResponse();
        return $response->setData($e);
    }
    public function rechercheExperienceJsonAction(Request $request,$nom, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository('MyAppUserBundle:User')->find($id);
        $experiences = $em->getRepository('MyAppUserBundle:Experience')->ExpressionParNom($nom);
        $e = null;
        foreach ($experiences as $experience) {
            $e[]=array(
                'id'=>$experience->getId(),
                'titre'=>$experience->getTitre(),
                'Description'=>$experience->getDescription(),
                'Pays'=>$experience->getIdPays()->getLibelle(),
                'Ville'=>$experience->getIdVille()->getLibelleVille(),
                'img'=>$experience->getImages()[0]->getUrl(),
                'IdUser'=>$experience->getIdUser()->getId(),
             //   'Video'=>$experience->getVideos()[0]->getUrl(),
            );
            $limg = null;
        }
        $response = new JsonResponse();
        return $response->setData($e);
    }

    public function villesJsonAction(Request $request, $idPays)
    {

            $em = $this->getDoctrine()->getManager();
            $villes = $em->getRepository('MyAppUserBundle:Ville')->findByidPays($idPays);
            foreach ($villes as $ville) {
                $v[] = array('nom'=>$ville->getLibelleVille(), 'id'=>$ville->getId());
            }
            $response = new JsonResponse();
            return $response->setData($v);
    }

    public function paysJsonAction(Request $request)
{

    $em = $this->getDoctrine()->getManager();
    $pays = $em->getRepository('MyAppUserBundle:Pays')->findAll();

    foreach ($pays as $pa) {
        $p[] = array('nom'=>$pa->getLibelle(), 'id'=>$pa->getId());
    }
    $response = new JsonResponse();
    return $response->setData($p);
}
    public function VideoJsonAction(Request $request,$id)
    {
$v=null;
        $em = $this->getDoctrine()->getManager();
        $experience=$em->getRepository('MyAppUserBundle:Experience')->find($id);

        $video = $em->getRepository('MyAppUserBundle:Video')->findOneBy(array('idExperience' => $experience));
        //dump($video);die();

            $v[] = array('url'=>$video->getUrl(), 'id'=>$video->getId(),'idExperience' => $video->getIdExperience()->getId());
        $response = new JsonResponse();
        return $response->setData($v);
    }

    function JsonExperienceAction()
    {

        $em = $this->getDoctrine()->getManager();
        $experiences = $em->getRepository('MyAppUserBundle:Experience')->findAll();
        $e = null;
        foreach ($experiences as $experience) {
            $e[]=array(
                'id'=>$experience->getId(),
                'titre'=>$experience->getTitre(),
                'Description'=>$experience->getDescription(),
                'Pays'=>$experience->getIdPays()->getLibelle(),
                'Ville'=>$experience->getIdVille()->getLibelleVille(),
                'img'=>$experience->getImages()[0]->getUrl(),
                'IdUser'=>$experience->getIdUser()->getId(),
                //  'Video'=>$experience->getVideos()[0]->getUrl(),
            );
            $limg = null;
        }
        $response = new JsonResponse();
        return $response->setData($e);
    }
}