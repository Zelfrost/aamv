<?php

namespace Aamv\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * DashboardController
 * 
 * @author  Guillaume COPIN
 * @package Aamv\AdminBundle\Controller
 */
class DashboardController extends Controller {

    /**
     * Display dashboard
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request) {

        return $this->render('AamvAdminBundle:dashboard:show.html.twig');
    }

}
