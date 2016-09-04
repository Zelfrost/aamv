<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @Route(path="/admin", name="admin")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Admin:index.html.twig');
    }
}
