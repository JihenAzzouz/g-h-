<?php
/**
 * Created by PhpStorm.
 * User: Imen Rajhi
 * Date: 25/03/2017
 * Time: 21:01
 */

namespace MyApp\UserBundle\Repository;
use Doctrine\ORM\EntityRepository;
use MyApp\UserBundle\MyAppUserBundle;
use Symfony\Component\HttpFoundation\Request;
use MyApp\AdminBundle\MyAppAdminBundle;

class AnnonceRepository extends EntityRepository
{

    function afficheHumouristeDQL($titre)
    {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('b')
            ->from('MyAppUserBundle:Annonce', 'b');


        if(!empty($titre->getTypeMaison())) {
            $qb->andWhere('b.typeMaison=:y')
                ->setParameter('y' , $titre->getTypeMaison());
        }
        if(!empty( $titre->getTypeLogement())) {
            $qb->andWhere('b.typeLogement=:z')
                ->setParameter('z' , $titre->getTypeLogement());
        }
        if(!empty($titre->getNbreLit())) {
            $qb->andWhere('b.nbreLit=:x')
                ->setParameter('x' , $titre->getNbreLit());
        } if(!empty($titre->getNombreVoyageur())) {
        $qb->andWhere('b.nombreVoyageur=:t')
            ->setParameter('t' , $titre->getNombreVoyageur());
    }
        if(!empty($titre->getidPays())) {
            $qb->andWhere('b.idPays=:a')
                ->setParameter('a' , $titre->getIdPays());
        }if(!empty($titre->getVille())) {
        $qb->andWhere('b.ville=:d')
            ->setParameter('d' , $titre->getVille());
    }
        if(!empty($titre->getPrix())) {
            $qb->andWhere('b.prix=:c')
                ->setParameter('c' , $titre->getPrix());
        }
        if(!empty($titre->getDateDebut())) {
            $qb->andWhere('b.dateDebut=:t')
                ->setParameter('t' , $titre->getDateDebut());
        }if(!empty($titre->getDateFin())) {
        $qb->andWhere('b.dateFin=:t')
            ->setParameter('t' , $titre->getDateFin());
    }
      return  $qb->getQuery()
          ->getResult();
    }
    function afficheAnnonce($id)
    {
        $req=$this->getEntityManager()->createQuery("select s from  MyAppUserBundle:Annonce s where s.idUser<>:y")->setParameter('y',$id);
        return $req->getResult();
    }

    function rechercherAnnonce()
    {

        $req=$this->getEntityManager()->createQuery("select s from  MyAppUserBundle:Annonce s where instr ('s.idPays','france')");
        return $req->getResult();
    }

    public function AnnonceMois ()
    {
        $req=$this->getEntityManager()->createQuery("select count (s) as total , s.idPays as nb from  MyAppUserBundle:Annonce s GROUP BY nb ");
        return $req->getResult();
    }


    public function findRandoByCaractere($caractere)
    {
        $query = $this->getEntityManager()
            ->createQuery("select r from MyAppUserBundle:Annonce r 
              WHERE r.idPays LIKE '$caractere%'");
        return $query->getResult();
    }



}