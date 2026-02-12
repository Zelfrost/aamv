<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use AppBundle\Entity\Tool;
use Doctrine\ORM\EntityRepository;

class ToolRepository extends EntityRepository
{
    public function findFiles(string $type, ?Category $category = null)
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
        } else {
            $builder->andWhere('t.category IS NULL');
        }

        return $builder->getQuery()->getResult();
    }

    public function findValidJoin()
    {
        return $this->createQueryBuilder('t')
            ->where('t.name = :name')
            ->andWhere('t.year IN (:years)')
            ->setParameters([
                'name' => Tool::JOIN_NAME,
                'years' => [(int) date('Y'), (int) date('Y') + 1],
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
