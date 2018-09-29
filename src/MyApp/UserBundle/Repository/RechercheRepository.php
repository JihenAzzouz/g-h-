<?php
/**
 * Created by PhpStorm.
 * User: amira
 * Date: 03/04/2017
 * Time: 21:03
 */

namespace MyApp\UserBundle\Repository;
use Doctrine\ORM\EntityRepository;


class RechercheRepository  extends EntityRepository
{
    public function findByMaison()
    {//methode 1
        $query = $this->getEntityManager()
            ->createQuery("
               select d  from MyAppUserBundle:Demande d where d.typeMaison='Appartemen'"
            );

        return $query->getResult();
    }
}