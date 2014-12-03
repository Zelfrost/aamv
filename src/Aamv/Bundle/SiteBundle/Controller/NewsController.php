<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class NewsController extends Controller {

    public function associationAction() {
        return $this->render('AamvSiteBundle:News:association.html.twig');
    }

    public function reunionAction() {
        return $this->render('AamvSiteBundle:News:reunion.html.twig');
    }

    public function objectifsAction() {
        
    }

    public function servicesamAction() {
        
    }

    public function servicesparentsAction() {
        
    }

    public function adhesionAction() {
        
    }

}
