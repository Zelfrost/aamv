<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class HomepageController extends Controller {

    public function indexAction() {
        return $this->render('AamvSiteBundle:homepage.html.twig');
    }

}
