<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DisponibilityRepository extends EntityRepository
{
    public function search($city, $neighborhood, $page)
    {
        $query = $this->createQueryBuilder('d')
            ->join('d.childminder', 'c')
            ->orderBy('d.id', 'DESC')
            ->setFirstResult(($page - 1) * 10)
            ->setMaxResults(10);

        if ("none" !== $city) {
            $query->andWhere('c.city = :city')
                ->setParameter('city', $city);
        }

        if ("none" !== $neighborhood) {
            $query->andWhere('c.neighborhood = :neighborhood')
                ->setParameter('neighborhood', $neighborhood);
        }

        return new Paginator($query);
    }
}
