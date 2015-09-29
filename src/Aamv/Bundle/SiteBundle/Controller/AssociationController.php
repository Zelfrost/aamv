<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class AssociationController extends AbstractController
{
    public function presentationAction()
    {
        return $this->render('AamvSiteBundle:Association:presentation.html.twig');
    }

    public function joinAction()
    {
        return $this->render('AamvSiteBundle:Association:join.html.twig');
    }

    public function photosAction()
    {
        return $this->render('AamvSiteBundle:Association:photos.html.twig');
    }

    public function aboutUsAction()
    {
        return $this->render('AamvSiteBundle:Association:about_us.html.twig');
    }
}
