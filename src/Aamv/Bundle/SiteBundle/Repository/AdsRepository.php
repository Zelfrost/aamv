<?php

namespace Aamv\Bundle\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AdsRepository extends EntityRepository
{
    public function countTotal()
    {
        $query = $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery();

        $result = $query->getOneOrNullResult();
        return $result[1];
    }

    public function findByPage($page, $resultsPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $resultsPerPage)
            ->setMaxResults($resultsPerPage);

        return new Paginator($query);
    }
}
