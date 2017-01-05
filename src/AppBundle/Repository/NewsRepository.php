<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class NewsRepository extends EntityRepository
{
    public function search($page)
    {
        $query = $this->createQueryBuilder('n')
            ->orderBy('n.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * 10)
            ->setMaxResults(10);

        return new Paginator($query);
    }

    public function count()
    {
        $query = $this->createQueryBuilder('n')
            ->select('count(n.id)')
            ->getQuery();

        $counts = $query->getSingleResult();

        return $counts[1];
    }
}
