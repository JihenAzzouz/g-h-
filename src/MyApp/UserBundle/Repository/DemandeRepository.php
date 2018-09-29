<?php
/**
 * Created by PhpStorm.
 * User: amira
 * Date: 10/04/2017
 * Time: 20:36
 */

namespace MyApp\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;


class DemandeRepository extends EntityRepository
{
    public function findNbDemande()
    {
        $query = $this->getEntityManager()
            ->createQuery("
               select count(d)  from MyAppUserBundle:Demande d"
            );

        return $query->getResult();

    }
    public function findNbDemandeParUser($user)
    {
        $query = $this->getEntityManager()
            ->createQuery("select count(d.id) as nb from
               MyAppUserBundle:Demande d where d.idUser= :user 
               ")->setParameter('user', $user);

               return $query->getResult();
    }




}