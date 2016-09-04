<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ToolRepository extends EntityRepository
{
    public function findAamvTools()
    {
        return $this->createQueryBuilder('t')
            ->where('t.fromAamv = true')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findVeronaliceTools()
    {
        return $this->createQueryBuilder('t')
            ->where('t.fromAamv = false')
            ->getQuery()
            ->getResult()
        ;
    }
}
