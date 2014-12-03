<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DiversController extends Controller
{
    public function articlesAction()
    {
        return $this->render('AamvSiteBundle:Divers:articles.html.twig');
    }

    public function adressesAction()
    {
        return $this->render('AamvSiteBundle:Divers:adresses.html.twig');
    }

    public function sitesAction()
    {
        return $this->render('AamvSiteBundle:Divers:sites_utiles.html.twig');
    }
}
