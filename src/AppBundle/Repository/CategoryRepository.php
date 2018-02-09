<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findFiles($type, $inversedCategoryOrder = false)
    {
        return $this->createQueryBuilder('c')
            ->select('c, to')
            ->addSelect('(CASE WHEN c.id IS NULL THEN 0 ELSE c.position END) AS HIDDEN ORD')
            ->join('c.tools', 'to')
            ->where('c.type = :type')
            ->setParameter('type', $type)
            ->orderBy('ORD', 'ASC')
            ->addOrderBy('c.name', $inversedCategoryOrder ? 'DESC' : 'ASC')
            ->addOrderBy('to.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOrdered($type)
    {
        return $this->queryForOrdered($type)
            ->getQuery()
            ->getResult()
        ;
    }

    public function queryForOrdered($type)
    {
        return $this->createQueryBuilder('c')
            ->addSelect('(CASE WHEN c.id IS NULL THEN 0 ELSE c.position END) AS HIDDEN ORD')
            ->where('c.type = :type')
            ->setParameter('type', $type)
            ->orderBy('ORD', 'ASC')
            ->addOrderBy('c.name', 'ASC')
        ;
    }
}
