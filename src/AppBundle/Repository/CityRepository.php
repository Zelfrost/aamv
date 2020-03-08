<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{
    public function findLike(string $name)
    {
        return $this->createQueryBuilder('c')
            ->select('c.name AS id')
            ->addSelect('c.name AS text')
            ->where('c.name LIKE :name')
            ->setParameter(':name', "%$name%")
            ->orderBy('c.name', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
