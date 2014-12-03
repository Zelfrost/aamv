<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class ServicesController extends Controller {

    public function annoncesAction() {
        return $this->render('AamvSiteBundle:Services:annonces.html.twig');
    }

    public function listeamAction() {
        return $this->render('AamvSiteBundle:Services:listeam.html.twig');
    }

    public function amvilleneuveAction() {
        return $this->render('AamvSiteBundle:Services:amvilleneuve.html.twig');
    }

    public function autorisationAction() {
        return $this->render('AamvSiteBundle:Services:autorisation.html.twig');
    }

    public function questionsreponsesAction() {
        return $this->render('AamvSiteBundle:Services:questionsreponses.html.twig');
    }

}
