<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class AssociationController extends Controller {

    public function presentationAction() {
        return $this->render('AamvSiteBundle:Association:presentation.html.twig');
    }

    public function historiqueAction() {
        return $this->render('AamvSiteBundle:Association:historique.html.twig');
    }

    public function objectifsAction() {
        return $this->render('AamvSiteBundle:Association:objectifs.html.twig');
    }

    public function servicesAmAction() {
        return $this->render('AamvSiteBundle:Association:servicesAm.html.twig');
    }

    public function servicesParentsAction() {
        return $this->render('AamvSiteBundle:Association:servicesParents.html.twig');
    }

    public function adhesionAction() {
        return $this->render('AamvSiteBundle:Association:adhesion.html.twig');
    }

}
