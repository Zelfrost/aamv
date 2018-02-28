<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

class ToolRepository extends EntityRepository
{
    public function findFiles(string $type, Category $category = null, bool $inversedOrder = false)
    {
        $builder = $this->createQueryBuilder('t')
            ->where('t.type = :type')
            ->setParameter('type', $type)
            ->orderBy(
                null === $category|| 'name' === $category->getOrderField() ? 't.name' : 't.date',
                null === $category|| 'name' === $category->getOrderField() ? 'ASC' : 'DESC'
            )
        ;

        if (null !== $category) {
            $builder->andWhere('t.category = :category')->setParameter('category', $category);
        }

        return $builder->getQuery()->getResult();
    }
}
