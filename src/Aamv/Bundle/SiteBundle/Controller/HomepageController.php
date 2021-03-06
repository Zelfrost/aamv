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
        $results['pagination']['route'] = 'aamv_site_homepage_news';

        return $this->render(
            'AamvSiteBundle:Homepage:index.html.twig',
            $results
        );
    }

    public function newAction($id)
    {
        $news = $this->getEntityManager()
            ->getRepository('AamvSiteBundle:News')
            ->find($id);

        if ($news === null) {
            return $this->redirectToUrl('aamv_site_homepage');
        }

        return $this->render(
            'AamvSiteBundle:Homepage:news.html.twig',
            array('news' => $news)
        );
    }
}
