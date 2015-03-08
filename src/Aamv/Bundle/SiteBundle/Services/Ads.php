<?php

namespace Aamv\Bundle\SiteBundle\Services;

use Doctrine\ORM\EntityManager;

class Ads
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

    /**
     * Retourne le contenu et la date formaté des annonces
     * @return type
     */
    public function getAds($page, $resultsPerPage)
    {
        $adsCount = $this->em
            ->getRepository('AamvSiteBundle:Ads')
            ->countTotal();

        $pagination = array(
            'page'        => $page,
            'pages_count' => ceil($adsCount / $resultsPerPage)
        );

        $ads = $this->em
            ->getRepository('AamvSiteBundle:Ads')
            ->findByPage($page, $resultsPerPage);

        return array('ads' => $ads, 'pagination' => $pagination);
    }
}
