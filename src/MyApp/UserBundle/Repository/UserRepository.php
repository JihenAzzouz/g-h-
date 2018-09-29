<?php
/**
 * Created by PhpStorm.
 * User: Imen Rajhi
 * Date: 25/03/2017
 * Time: 17:52
 */

namespace MyApp\UserBundle\Repository;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getActive()
    {
        $delay = new \DateTime();
        $delay->setTimestamp(strtotime('2 minutes ago'));
        $qb = $this->createQueryBuilder('u')
            ->where('u.lastActivityAt > :delay')
            ->setParameter('delay', $delay);
        return $qb->getQuery()->getResult();
    }
}