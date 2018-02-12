<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AdRepository extends EntityRepository
{
    public function search($role, $city, $neighborhood, $page)
    {
        $query = $this->createQueryBuilder('n')
            ->join('n.author', 'u')
            ->where('u.roles LIKE :role')
            ->andWhere('n.createdAt > :date')
            ->setParameters([
                'role' => '%'.$role.'%',
                'date' => (new \DateTime())->sub(new \DateInterval('P1M'))
            ])
            ->orderBy('n.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * 10)
            ->setMaxResults(10)
        ;

        if ("none" !== $city) {
            $query
                ->andWhere('u.city = :city')
                ->setParameter('city', $city)
            ;
        }

        if ("none" !== $neighborhood) {
            $query
                ->andWhere('u.neighborhood = :neighborhood')
                ->setParameter('neighborhood', $neighborhood)
            ;
        }

        return new Paginator($query);
    }

    public function getCities($role)
    {
        return $this->createQueryBuilder('n')
            ->select('u.city, u.neighborhood')
            ->join('n.author', 'u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%'.$role.'%')
            ->groupBy('u.city, u.neighborhood')
            ->orderBy('u.city', 'ASC')
            ->getQuery()
            ->getScalarResult()
        ;
    }
}
