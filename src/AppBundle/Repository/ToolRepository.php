<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Tool;
use Doctrine\ORM\EntityRepository;

class ToolRepository extends EntityRepository
{
    public function findAllTools()
    {
        return $this->createQueryBuilder('t')
            ->where('t.name NOT IN (:common_files)')
            ->setParameter('common_files', [
                Tool::JOIN_NAME,
                Tool::DISPONIBILITIES_NAME,
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
