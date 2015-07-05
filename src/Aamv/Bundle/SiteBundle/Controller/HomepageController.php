<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    public function indexAction($page = 1)
    {
        $resultsPerPage = $this->container->getParameter('news.results_per_page');

        $results = $this->get('aamv_site.publishables_getter')->get(
            'News',
            $page,
            $resultsPerPage
        );

        return $this->render(
            'AamvSiteBundle:Homepage:index.html.twig',
            $results
        );
    }
}
