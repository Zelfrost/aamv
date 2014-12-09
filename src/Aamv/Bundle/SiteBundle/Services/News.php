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
        $newsCount = $this->em
            ->getRepository('AamvSiteBundle:News')
            ->countTotal();

        $pagination = array(
            'page'       => $page,
            'route'      => 'aamv_site_news',
            'pages_count' => ceil($newsCount / $resultsPerPage)
        );

        $news = $this->em
            ->getRepository('AamvSiteBundle:News')
            ->findByPage($page, $resultsPerPage);

        return array('news' => $news, 'pagination' => $pagination);
    }
}
