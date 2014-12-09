<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class ServicesController extends AbstractController
{
    public function annoncesAction()
    {
        return $this->render('AamvSiteBundle:Services:annonces.html.twig');
    }

    public function outilsAction()
    {
        return $this->render('AamvSiteBundle:Services:outils.html.twig');
    }

    public function questionsReponsesAction()
    {
        return $this->render('AamvSiteBundle:Services:questions_reponses.html.twig');
    }
}
