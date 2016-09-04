<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AssociationController extends Controller
{
    /**
     * @Route(path="/association/presentation", name="association_presentation")
     */
    public function presentationAction()
    {
        return $this->render('AppBundle:Association:presentation.html.twig');
    }

    /**
     * @Route(path="/association/join", name="association_join")
     */
    public function joinAction()
    {
        return $this->render('AppBundle:Association:join.html.twig');
    }

    /**
     * @Route(path="/association/pictures", name="association_pictures")
     */
    public function picturesAction()
    {
        return $this->render('AppBundle:Association:pictures.html.twig');
    }

    /**
     * @Route(path="/association/about_us", name="association_about_us")
     */
    public function aboutUsAction()
    {
        return $this->render('AppBundle:Association:about_us.html.twig');
    }

    /**
     * @Route(path="/association/contacts", name="association_contacts")
     */
    public function contactsAction()
    {
        return $this->render('AppBundle:Association:contacts.html.twig');
    }
}
