<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Aamv\Bundle\DefaultBundle\Controller\AbstractController;
use Aamv\Bundle\SiteBundle\Form\Type\AdFormType;

class ServicesController extends AbstractController
{
    public function adsAction($type, $city, $page)
    {
        $resultsPerPage = $this->container->getParameter('ads.results_per_page');
        if ('parents' === $type) {
            $role = '%ROLE_PARENT%';
        } else {
            $role = '%ROLE_ASSISTANTE%';
        }

        $options = array(
            'role' => array(
                'value' => $role
            )
        );

        if ($city !== 'none') {
            $options['city'] = array(
                'value' => $city
            );
        }

        $results = $this->get('aamv_site.publishables_getter')->get(
            'Ad',
            $page,
            $resultsPerPage,
            $options
        );

        $results['title'] = 'Petites annonces';
        $results['type'] = $type;
        $results['city'] = $city;
        $results['cities'] = $this->getRepository('AamvSiteBundle:User')->getCities('%ROLE_ASSISTANTE%');

        $results['pagination']['route'] = 'aamv_site_services_ads';
        $results['pagination']['parameters'] = array(
            'type' => $type,
            'city' => $city
        );

        return $this->render(
            'AamvSiteBundle:Services:list_ad.html.twig',
            $results
        );
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

            return $this->redirect($this->generateUrl('aamv_site_services_ads', array('type' => $this->get('aamv_site.role_retriever')->getNameFromUser($user))));
        }

        return $this->render(
            'AamvSiteBundle:Services:create_ad.html.twig',
            array('form' => $form->createView())
        );
    }

    public function outilsAction()
    {
        $aamvTools = $this->getRepository('AamvSiteBundle:Tools')
            ->findAamvTools();
        $veronaliceTools = $this->getRepository('AamvSiteBundle:Tools')
            ->findVeronaliceTools();

        return $this->render(
            'AamvSiteBundle:Services:outils.html.twig',
            array('tools' => array(
                'aamv' => $aamvTools,
                'veronalice' => $veronaliceTools,
            ))
        );
    }

    public function questionsReponsesAction()
    {
        return $this->render('AamvSiteBundle:Services:questions_reponses.html.twig');
    }
}
