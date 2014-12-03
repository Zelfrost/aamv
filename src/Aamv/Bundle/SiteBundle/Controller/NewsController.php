<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function associationAction()
    {
        return $this->render('AamvSiteBundle:News:association.html.twig');
    }

    public function reunionAction()
    {
        return $this->render('AamvSiteBundle:News:reunions.html.twig');
    }
}
