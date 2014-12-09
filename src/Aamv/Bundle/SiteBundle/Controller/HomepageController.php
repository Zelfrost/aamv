<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    public function indexAction()
    {
        return $this->render('AamvSiteBundle:Homepage:index.html.twig');
    }
}
