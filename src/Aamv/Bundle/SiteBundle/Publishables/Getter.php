<?php

namespace Aamv\Bundle\SiteBundle\Publishables;

use Doctrine\ORM\EntityManager;

class Getter
{
    protected $em;

    /**
     * Constructeur de la classe Ads
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function get($entityName, $page, $resultsPerPage)
    {
        $repository = $this->em
            ->getRepository(sprintf('AamvSiteBundle:%s', $entityName));

        $finder = new Finder($repository);

        $publishableCount = $finder->countTotal();

        $pagination = array(
            'page'        => $page,
            'pages_count' => ceil($publishableCount / $resultsPerPage)
        );

        $publishables = $finder->findByPage($page, $resultsPerPage);

        return array('publishables' => $publishables, 'pagination' => $pagination);
    }
}