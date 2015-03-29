<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    public function indexAction($page)
    {
        $resultsPerPage = $this->container->getParameter('news.results_per_page');

        $results = $this->get('aamv_site.publishables_getter')->get(
            'News',
            $page,
            $resultsPerPage
        );

        $results['title']               = 'Les dernières news';
        $results['pagination']['route'] = 'aamv_site_news';

        return $this->render(
            'AamvSiteBundle:Publishables:list.html.twig',
            $results
        );
    }
}
