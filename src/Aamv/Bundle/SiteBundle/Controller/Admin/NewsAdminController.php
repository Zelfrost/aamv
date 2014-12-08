<?php

namespace Aamv\Bundle\SiteBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsAdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('AamvSiteBundle:News:index.html.twig');
    }
}
