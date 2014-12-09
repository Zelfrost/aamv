<?php

namespace Aamv\Bundle\SiteBundle\Controller\Admin;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class NewsAdminController extends AbstractController
{
    public function indexAction()
    {
        return $this->render('AamvSiteBundle:Admin/News:news_admin.html.twig');
    }
}
