<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class ManagementController extends AbstractController
{
    public function accountAction()
    {
        $form = $this->createForm('aamv_user_registration', $this->getUser());

        return $this->render('AamvSiteBundle:Management:account.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function adsAction()
    {
        return $this->render('AamvSiteBundle:Management:ads.html.twig');
    }

    public function disponibilitiesAction()
    {
        return $this->render('AamvSiteBundle:Management:disponibilities.html.twig');
    }
}
