<?php

namespace Aamv\Bundle\SiteBundle\Services;

use Doctrine\ORM\EntityManager;

class News
{

    protected $em;

    /**
     * Constructeur de la classe News
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Retourne le contenu et la date formaté des news
     * @return type
     */
    public function getNews($page, $resultsPerPage)
    {
        return $this->em
            ->getRepository('AamvSiteBundle:News')
            ->findByPage($page, $resultsPerPage);
    }

}
