<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {
        return $this->render('AamvSiteBundle:News:index.html.twig');
    }
}
