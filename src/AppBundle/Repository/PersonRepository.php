<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Person;
use Doctrine\ORM\EntityRepository;

class PersonRepository extends EntityRepository
{
    /**
     * @return Person|null
     */
    public function findPersonOnly(string $email)
    {
        return $this->createQueryBuilder('p')
            ->where('p.email = :email')
            ->andWhere('NOT EXISTS (SELECT us.id FROM AppBundle\Entity\User us WHERE us.email = :email)')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}