<?php

namespace MyApp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;

class ReservationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function chartLineAction()
    {
        $em = $this->getDoctrine()->getManager();//invoquer ORM
        $classes = $em->getRepository('MyAppUserBundle:Reservation')->findAll();

        $tab = array();
        $categories = array();
        foreach ($classes as $classe) {
            array_push($tab, $classe->getIdAnnonce()->getAdresse() );
            array_push($categories,$classe->getIdUser()->getNom() );
        }

        // Chart
        $series = array(array("id Annonce" => "Nb réservations", "data" => $tab));
        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  //  #id du div où afficher le graphe
        $ob->title->text('Nombre des réservations par niveau');
        $ob->xAxis->title(array('text' => "idAnnonce"));
        $ob->yAxis->title(array('text' => "Nb réservations"));
        $ob->xAxis->categories($categories);
        $ob->series($series);

        return $this->render('MyAppAdminBundle:carte:essai.html.twig', array('chart' => $ob));
    }
}
