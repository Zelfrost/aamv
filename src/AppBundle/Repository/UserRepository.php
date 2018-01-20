<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepository extends EntityRepository
{
    public function search($email, $role, $page)
    {
        $builder = $this->createQueryBuilder('u')
            ->orderBy('u.email', 'ASC')
            ->setFirstResult(($page - 1) * 30)
            ->setMaxResults(30)
        ;

        if (!empty($role)) {
            if ($role === 'not-member') {
                $role = 'assistant';

                $builder
                    ->where('u.roles NOT LIKE :role_member')
                    ->setParameter('role_member', '%"ROLE_MEMBER"%')
                ;
            }

            $builder
                ->andWhere('u.roles like :role')
                ->setParameter('role', '%'.sprintf(
                    '"ROLE_%s"',
                    strtoupper($role)
                ) . '%')
            ;
        }

        if (!empty($email)) {
            $builder
                ->andWhere('u.email LIKE :email')
                ->setParameter('email', '%'.$email.'%')
            ;
        }

        return new Paginator($builder);
    }

    public function getCities($type)
    {
        $cities = $this->createQueryBuilder('u')
            ->select('u.city')
            ->where('u.roles LIKE :role')
            ->setParameter('role', $type)
            ->orderBy('u.city', 'ASC')
            ->distinct()
            ->getQuery();

        return $cities->getResult();
    }

    public function getNeighborhoods($role)
    {
        $neighborhoods = $this->createQueryBuilder('u')
            ->select('u.neighborhood')
            ->where('u.roles LIKE :role')
            ->andWhere('u.neighborhood IS NOT NULL')
            ->setParameter('role', $role)
            ->orderBy('u.neighborhood', 'ASC')
            ->distinct()
            ->getQuery();

        return $neighborhoods->getResult();
    }
}
