<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AssociationController extends Controller
{
    public function presentationAction()
    {
        return $this->render('AamvSiteBundle:Association:presentation.html.twig');
    }

    public function photosAction()
    {
        return $this->render('AamvSiteBundle:Association:photos.html.twig');
    }

    public function parleAction()
    {
        return $this->render('AamvSiteBundle:Association:parle.html.twig');
    }
}
