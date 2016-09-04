<?php

namespace AppBundle\Publishables;

use Doctrine\ORM\EntityManager;

class Getter
{
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function get($entity, $page, $resultsPerPage, $options = array())
    {
        $repository = $this->em
            ->getRepository($entity);

        $finder = new Finder($repository);

        $publishableCount = $finder->countTotal();

        $pagination = array(
            'page'        => $page,
            'pages_count' => ceil($publishableCount / $resultsPerPage),
            'parameters'  => array()
        );

        $publishables = $repository->findByPage($page, $resultsPerPage, $options);

        return array('publishables' => $publishables, 'pagination' => $pagination);
    }
}