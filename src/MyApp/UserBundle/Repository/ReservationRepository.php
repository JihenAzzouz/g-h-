<?php
/**
 * Created by PhpStorm.
 * User: rim
 * Date: 02/04/2017
 * Time: 19:31
 */

namespace MyApp\UserBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ReservationRepository extends EntityRepository
{
    public function findRandoByCaractere($caractere)
    {
        $query = $this->getEntityManager()
            ->createQuery("select a from MyAppUserBundle:Annonce a 
              WHERE a.adresse LIKE '$caractere%'");
        return $query->getResult();
    }

    public function RechercheDate($res,$id)
    {
        $query = $this->getEntityManager()
            ->createQuery("select r  from MyAppUserBundle:Reservation r 
              WHERE r.dateDebut >=:dd AND r.dateFin <=:df AND r.etat IN ('Acceptee','Payee') AND r.idAnnonce =$id")
        ->setParameters(array('dd'=>$res->getDateDebut(),'df'=>$res->getDateFin()));

        return $query->getResult();
    }

}