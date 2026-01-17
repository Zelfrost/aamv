<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Tool;
use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findFiles(string $type, bool $forMembers = null): array
    {
        $builder = $this->createQueryBuilder('c')
            ->addSelect('(CASE WHEN c.id IS NULL THEN 0 ELSE c.position END) AS HIDDEN ORD')
            ->where('c.type = :type')
            ->setParameter('type', $type)
            ->orderBy('ORD', 'ASC')
            ->addOrderBy('c.name', 'DESC')
        ;

        if (null !== $forMembers) {
            $builder->andWhere('c.forMembers = :forMembers')->setParameter('forMembers', $forMembers);
        }

        $categories = $builder->getQuery()->getResult();

        foreach ($categories as $key => $category) {
            $tools = $this->_em->getRepository(Tool::class)->findFiles($type, $category);

            if (empty($tools)) {
                unset($categories[$key]);
                continue;
            }

            $category->setTools($tools);
        }

        return $categories;
    }

    public function findOrdered($type)
    {
        return $this->queryForOrdered($type)
            ->getQuery()
            ->getResult()
            ;
    }

    public function queryForOrdered($type)
    {
        return $this->createQueryBuilder('c')
            ->addSelect('(CASE WHEN c.id IS NULL THEN 0 ELSE c.position END) AS HIDDEN ORD')
            ->where('c.type = :type')
            ->setParameter('type', $type)
            ->orderBy('ORD', 'ASC')
            ->addOrderBy('c.name', 'ASC')
            ;
    }
}
