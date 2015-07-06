<?php

namespace Aamv\Bundle\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ToolsRepository extends EntityRepository
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
