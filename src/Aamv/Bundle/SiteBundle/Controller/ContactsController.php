<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class ContactsController extends Controller {

    public function demandeAction() {
        return $this->render('AamvSiteBundle:Contacts:demande.html.twig');
    }

    public function nouscontacterAction() {
        return $this->render('AamvSiteBundle:Contacts:nouscontacter.html.twig');
    }
}
