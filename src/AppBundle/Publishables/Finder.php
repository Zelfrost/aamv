<?php

namespace AppBundle\Publishables;

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
}
