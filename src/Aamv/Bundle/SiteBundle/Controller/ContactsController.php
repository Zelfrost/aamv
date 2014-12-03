<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class ContactsController extends Controller
{
    public function indexAction()
    {
        return $this->render('AamvSiteBundle:Contacts:index.html.twig');
    }
}
