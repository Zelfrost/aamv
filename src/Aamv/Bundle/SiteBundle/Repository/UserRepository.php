<?php

namespace Aamv\Bundle\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getCities($type)
    {
        $cities = $this->createQueryBuilder('u')
            ->select('u.city')
            ->where('u.roles LIKE :role')
            ->setParameter('role', $type)
            ->orderBy('u.city', 'ASC')
            ->distinct()
            ->getQuery();

        return $cities->getResult();
    }

    public function getNeighborhoods($type)
    {
        $neighborhoods = $this->createQueryBuilder('u')
            ->select('u.neighborhood')
            ->where('u.roles LIKE :role')
            ->andWhere('u.neighborhood IS NOT NULL')
            ->setParameter('role', $type)
            ->orderBy('u.neighborhood', 'ASC')
            ->distinct()
            ->getQuery();

        return $neighborhoods->getResult();
    }
}
