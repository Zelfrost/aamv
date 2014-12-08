<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {
        $news = $this->get('aamv_site_news.get_news')->getNews();

        return $this->render('AamvSiteBundle:News:index.html.twig', array('news' => $news));
    }
}
