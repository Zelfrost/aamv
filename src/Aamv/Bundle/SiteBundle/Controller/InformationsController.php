<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class InformationsController extends Controller {

    public function savoirAction() {
        return $this->render('AamvSiteBundle:Informations:savoir.html.twig');
    }

    public function adressesAction() {
        return $this->render('AamvSiteBundle:Informations:adresses.html.twig');
    }

    public function voirAction() {
        return $this->render('AamvSiteBundle:Informations:voir.html.twig');
    }
}
