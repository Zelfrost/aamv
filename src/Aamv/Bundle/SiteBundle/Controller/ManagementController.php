<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ManagementController extends AbstractController
{
    public function accountAction(Request $request)
    {
        $form = $this->createForm('aamv_user_profile', $this->getUser());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $form->getData();

            $this->getEntityManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('management.account.success', "Votre compte a bien été modifié.");
        }

        return $this->render('AamvSiteBundle:Management:account.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function adsAction()
    {
        $ads = $this->getRepository('AamvSiteBundle:Ad')
            ->findByAuthor($this->getUser());

        return $this->render('AamvSiteBundle:Management:ads.html.twig', array(
            'ads' => $ads
        ));
    }

    public function createAdAction(Request $request)
    {
        $manager = $this->get('doctrine')->getManager();
        $user = $this->getUser();

        $form = $this->createForm('aamv_site_create_ad');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $ad = $form->getData();
            $ad->setAuthor($user);

            $manager->persist($ad);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('management.ads.success', "Votre annonce a bien été crée.");

            return $this->redirect($this->generateUrl('aamv_site_manage_ads', array('type' => $this->get('aamv_site.role_retriever')->getNameFromUser($user))));
        }

        return $this->render(
            'AamvSiteBundle:Management:create_ad.html.twig',
            array('form' => $form->createView())
        );
    }

    public function editAdAction(Request $request, $id)
    {
        $session = $this->get("session");
        $manager = $this->get('doctrine')->getManager();
        $ad = $this->getRepository('AamvSiteBundle:Ad')
            ->find($id);

        if ($this->getUser()->getId() !== $ad->getAuthor()->getId()) {
            $session->getFlashBag()->add('management.ads.error', "Cette annonce ne vous appartient pas.");

            return $this->redirect($this->generateUrl('aamv_site_manage_ads'));
        }

        if (null === $ad) {
            $session->getFlashBag()->add('management.ads.error', "Cette annonce n'existe pas.");

            return $this->redirect($this->generateUrl('aamv_site_manage_ads'));
        }

        $form = $this->createForm('aamv_site_create_ad', $ad);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $ad = $form->getData();

            $manager->persist($ad);
            $manager->flush();

            $session->getFlashBag()->add('management.ads.success', "Votre annonce a bien été modifiée.");
        }

        return $this->render('AamvSiteBundle:Management:edit_ad.html.twig', array(
            'ad' => $ad,
            'form' => $form->createView()
        ));
    }

    public function deleteAdAction($id)
    {
        $session = $this->get("session");
        $ad = $this->getRepository('AamvSiteBundle:Ad')
            ->find($id);

        if (null === $ad) {
            $session->getFlashBag()->add('management.ads.error', "Cette annonce n'existe pas.");
        } else {
            if ($this->getUser()->getId() !== $ad->getAuthor()->getId()) {
                $session->getFlashBag()->add('management.ads.error', "Cette annonce ne vous appartient pas.");
            } else {
                $this->getEntityManager()
                    ->remove($ad);
                $this->getEntityManager()
                    ->flush();

                $session->getFlashBag()->add('management.ads.success', "Votre annonce a bien été supprimée.");
            }
        }

        return $this->redirect($this->generateUrl('aamv_site_manage_ads'));
    }

    public function disponibilitiesAction()
    {
        return $this->render('AamvSiteBundle:Management:disponibilities.html.twig');
    }
}
