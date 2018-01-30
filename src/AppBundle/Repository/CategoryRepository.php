<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findFiles($type)
    {
        $underYear = $this->createQueryBuilder('c')
            ->select('MAX(c.year) - 0.5')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $this->createQueryBuilder('c')
            ->select('c, to')
            ->addSelect('(CASE WHEN c.year IS NULL THEN :underYear ELSE c.year END) AS HIDDEN ORD')
            ->join('c.tools', 'to')
            ->where('to.type = :type')
            ->setParameters([
                'type' => $type,
                'underYear' => $underYear
            ])
            ->orderBy('ORD', 'DESC')
            ->addOrderBy('c.name', 'ASC')
            ->addOrderBy('to.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOrdered()
    {
        $underYear = $this->createQueryBuilder('c')
            ->select('MAX(c.year) - 0.5')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $this->createQueryBuilder('c')
            ->addSelect('(CASE WHEN c.year IS NULL THEN :underYear ELSE c.year END) AS HIDDEN ORD')
            ->setParameter('underYear', $underYear)
            ->orderBy('ORD', 'DESC')
            ->addOrderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
