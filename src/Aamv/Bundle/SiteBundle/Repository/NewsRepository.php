<?php

namespace Aamv\Bundle\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{
    public function findByPage($page, $resultsPerPage)
    {
        $first = ($page - 1) * $resultsPerPage;

        $query = $this->createQueryBuilder('n')
            ->orderBy('n.createdAt', 'DESC')
            ->setFirstResult($first)
            ->setMaxResults($first + ($page * $resultsPerPage))
            ->getQuery();

        return $query->getResult();
    }
}
