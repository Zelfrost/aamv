<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class DiversController extends AbstractController
{
    public function articlesAction()
    {
        return $this->render('AamvSiteBundle:Divers:articles.html.twig');
    }

    public function questionsReponsesAction()
    {
        return $this->render('AamvSiteBundle:Services:questions_reponses.html.twig');
    }

    public function addressesAction()
    {
        return $this->render('AamvSiteBundle:Divers:adresses.html.twig');
    }

    public function sitesAction()
    {
        return $this->render('AamvSiteBundle:Divers:sites_utiles.html.twig');
    }
}
