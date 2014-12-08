<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {
        $page = 0;
        $resultsPerPage = $this->container->getParameter('news.results_per_page');

        $news = $this->get('aamv_site_news.get_news')->getNews($page, $resultsPerPage);

        return $this->render('AamvSiteBundle:News:index.html.twig', array('news' => $news));
    }
}
