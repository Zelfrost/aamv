<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class ContactsController extends AbstractController
{
    public function indexAction()
    {
        return $this->render('AamvSiteBundle:Contacts:index.html.twig');
    }
}
