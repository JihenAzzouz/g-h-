<?php

namespace MyApp\AdminBundle\Controller;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ForumController extends Controller
{
    function forumStatAction()
    {
        $em=$this->getDoctrine()->getManager();
        $users = $this->getDoctrine()->getManager()->getRepository('MyAppUserBundle:User')->getActive();
        $discussions = $em->getRepository('MyAppUserBundle:Discussion')->findAll();
        $reponses = $em->getRepository('MyAppUserBundle:Reponse')->findAll();
        $categories=$em->getRepository('MyAppUserBundle:Categorie')->findAll();
        $utilisateurs = $em->getRepository('MyAppUserBundle:User')->findAll();
        $topdisl = $em->getRepository('MyAppUserBundle:Discussion')->findBy(array(), array('nblikes' => 'DESC'),5);
        $topdisv = $em->getRepository('MyAppUserBundle:Discussion')->findBy(array(), array('nbvues' => 'DESC'),5);
        $topdisr = $em->getRepository('MyAppUserBundle:Discussion')->findBy(array(), array('nbrep' => 'DESC'),5);
//        Pie chat
        $nbcat = sizeof($categories);
        $nbrep = sizeof($reponses);
        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Activité du forum par rapport aux catégories');
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));
          $data = array();
            for ($i = 0; $i < $nbcat; $i++) {
                $data[$i] = array($categories[$i]->getTitre(), $categories[$i]->getNbmsg());
            }

//            line chart

        return $this->render('MyAppAdminBundle:Forum:AdministrationForum.html.twig', array(
            'c'=>$categories,'users' => $users,
            'dis'=>$discussions, 'rep' => $reponses , 'utlisateurs' =>$utilisateurs,
            'chart' => $ob->series(array(array('type' => 'pie','name' => 'Browser share', 'data' => $data))),
            'topdisl' => $topdisl,
            'topdisv' => $topdisv,
            'topdisr' => $topdisr,
        ));
    }
}
