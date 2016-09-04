<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class NewsRepository extends EntityRepository
{
    public function findByPage($page, $resultsPerPage, $options)
    {
        $query = $this->createQueryBuilder('n')
            ->orderBy('n.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $resultsPerPage)
            ->setMaxResults($resultsPerPage);

        return new Paginator($query);
    }
}
