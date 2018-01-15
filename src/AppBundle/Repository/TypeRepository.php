<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TypeRepository extends EntityRepository
{
    public function findTyped($fromAamv)
    {
        return $this->createQueryBuilder('t')
            ->select('t, to')
            ->join('t.tools', 'to')
            ->where('to.fromAamv = :fromAamv')
            ->setParameter('fromAamv', $fromAamv)
            ->getQuery()
            ->getResult()
        ;
    }
}
