<?php

namespace ArmyDataBundle\Repository;

/**
 * ArmyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArmyRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCollect ($army){
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('
            SELECT a, w
            FROM ArmyDataBundle:Army a JOIN a.weapons w
            WHERE a.id = :id
        ');
        $consulta->setParameter('id', $army);

        return $consulta->getResult();
    }
}