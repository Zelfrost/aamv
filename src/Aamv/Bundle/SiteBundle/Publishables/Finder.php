<?php

namespace Aamv\Bundle\SiteBundle\Publishables;

use Doctrine\ORM\Tools\Pagination\Paginator;

class Finder
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function countTotal()
    {
        $query = $this->repository->createQueryBuilder('n')
            ->select('count(n.id)')
            ->getQuery();

        $result = $query->getOneOrNullResult();
        return $result[1];
    }

    public function findByPage($page, $resultsPerPage)
    {
        $query = $this->repository->createQueryBuilder('n')
            ->orderBy('n.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $resultsPerPage)
            ->setMaxResults($resultsPerPage);

        return new Paginator($query);
    }
}
