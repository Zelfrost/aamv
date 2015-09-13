<?php

namespace Aamv\Bundle\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AdsRepository extends EntityRepository
{
    public function findByPage($page, $resultsPerPage, $options)
    {
        $query = $this->createQueryBuilder('n')
            ->join('n.author', 'u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', $options['role']['value'])
            ->orderBy('n.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $resultsPerPage)
            ->setMaxResults($resultsPerPage);

        if (isset($options['city'])) {
            $query->andWhere('u.city = :city')
                ->setParameter('city', $options['city']['value']);
        }

        return new Paginator($query);
    }
}
