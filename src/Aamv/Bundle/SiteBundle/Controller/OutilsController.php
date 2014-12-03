<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class OutilsController extends Controller {

    public function outilsAction() {
        return $this->render('AamvSiteBundle:Outils:outils.html.twig');
    }

    public function formulairesAction() {
        return $this->render('AamvSiteBundle:Outils:formulaires.html.twig');
    }

    public function salaireAction() {
        return $this->render('AamvSiteBundle:Outils:salaire.html.twig');
    }
}
