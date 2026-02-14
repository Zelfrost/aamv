<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route(path: '/admin', name: 'admin')]
    public function indexAction()
    {
        return $this->render('@AppBundle/Admin/index.html.twig');
    }
}
