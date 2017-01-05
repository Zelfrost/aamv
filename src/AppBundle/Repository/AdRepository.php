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
            ->setParameter('role', '%'.$role.'%')
            ->orderBy('n.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * 10)
            ->setMaxResults(10);

        if ("none" !== $city) {
            $query->andWhere('u.city = :city')
                ->setParameter('city', $city);
        }

        if ("none" !== $neighborhood) {
            $query->andWhere('u.neighborhood = :neighborhood')
                ->setParameter('neighborhood', $neighborhood);
        }

        return new Paginator($query);
    }
}
