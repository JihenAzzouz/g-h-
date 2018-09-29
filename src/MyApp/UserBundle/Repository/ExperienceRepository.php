<?php

/**
 * Created by PhpStorm.
 * User: MohamedKhyari
 * Date: 20/03/2017
 * Time: 16:33
 */
namespace MyApp\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ExperienceRepository extends EntityRepository
{
    public function findExperienceByContinent($id)
    {
        $query = $this->getEntityManager()
            ->createQuery("
    select e
    from MyAppUserBundle:Experience e , MyAppUserBundle:Pays p
    WHERE e.idPays= p.id
    AND 
    p.idContinent=:idcontinent
    ")
            ->setParameter('idcontinent', $id);
        return $query->getResult();


    }

    public function NombreDeExpressionParContinent()
    {
        $query = $this->getEntityManager()
            ->createQuery("
SELECT  COUNT(e.id) AS nb ,c.nom as nom from
MyAppUserBundle:experience e join MyAppUserBundle:pays p
with e.idPays = p.id join MyAppUserBundle:continent c
with c.id=p.idContinent
GROUP BY c.id 
ORDER BY c.id  ");
        return $query->getResult();
    }

    public function ExpressionParContinentNom($nom,$continent)
    {
        $query = $this->getEntityManager()
            ->createQuery("
    select e
    from MyAppUserBundle:Experience e , MyAppUserBundle:Continent c, MyAppUserBundle:pays p
    WHERE   c.id= :continent AND e.titre LIKE :nom AND  (c.id=IDENTITY(p.idContinent)) AND (IDENTITY(e.idPays) = p.id)");

        $query->setParameter('nom', '%'.$nom.'%');
        $query->setParameter('continent', $continent);
        return $query->getResult();
    }

    public function ExpressionParNom($nom)
    {
        $query = $this->getEntityManager()
            ->createQuery("
    select e
    from MyAppUserBundle:Experience e
    WHERE e.titre LIKE :nom");

        $query->setParameter('nom', '%'.$nom.'%');
        return $query->getResult();
    }


    public function ExpressionParVille($idPays,$user)
    {
        $query = $this->getEntityManager()
            ->createQuery("
SELECT  COUNT(e.id) AS nbExp, v.libelleVille AS libelleville from
MyAppUserBundle:experience e join MyAppUserBundle:ville v
with e.idVille = v.id
AND e.idPays = :idPays
AND e.idUser = :idUser
GROUP BY e.idVille
");
        $query->setParameter('idPays',$idPays);
        $query->setParameter('idUser',$user);
        return $query->getResult();
    }
}