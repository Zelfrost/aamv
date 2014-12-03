<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class ServicesController extends Controller
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
