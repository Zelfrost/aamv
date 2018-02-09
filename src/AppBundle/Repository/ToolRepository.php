<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ToolRepository extends EntityRepository
{
    public function findFiles($type)
    {
        return $this->createQueryBuilder('t')
            ->where('t.category IS NULL')
            ->andWhere('t.type = :type')
            ->setParameter('type', $type)
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
