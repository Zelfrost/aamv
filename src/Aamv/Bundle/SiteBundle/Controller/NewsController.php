<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    public function indexAction($page)
    {
        $resultsPerPage = $this->container->getParameter('news.results_per_page');

        $results = $this->get('aamv_site_news.get_news')->getNews($page, $resultsPerPage);

        return $this->render(
            'AamvSiteBundle:News:index.html.twig',
            $results
        );
    }
}
