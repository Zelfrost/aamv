<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class NewsController extends Controller {

    public function associationAction() {
        return $this->render('AamvSiteBundle:News:association.html.twig');
    }

    public function reunionsAction() {
        return $this->render('AamvSiteBundle:News:reunions.html.twig');
    }
}
