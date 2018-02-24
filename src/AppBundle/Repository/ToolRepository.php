<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

class ToolRepository extends EntityRepository
{
    public function findFiles(string $type, Category $category = null, bool $inversedOrder = false)
    {
        return $this->createQueryBuilder('t')
            ->where('t.category = :category')
            ->andWhere('t.type = :type')
            ->setParameter('type', $type)
            ->setParameter('category', $category)
            ->orderBy(
                null === $category|| 'name' === $category->getOrderField() ? 't.name' : 't.date',
                null === $category|| 'name' === $category->getOrderField() ? 'ASC' : 'DESC'
            )
            ->getQuery()
            ->getResult()
        ;
    }
}
