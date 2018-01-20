<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TypeRepository extends EntityRepository
{
    public function findTools()
    {
        return $this->createQueryBuilder('t')
            ->select('t, to')
            ->join('t.tools', 'to')
            ->orderBy('t.year', 'DESC')
            ->addOrderBy('t.name', 'ASC')
            ->addOrderBy('to.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
