<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Aamv\Bundle\DefaultBundle\Controller\AbstractController;
use Aamv\Bundle\SiteBundle\Form\Type\AdFormType;

class ServicesController extends AbstractController
{
    public function adsAction($type, $city, $neighborhood, $page)
    {
        $resultsPerPage = $this->container->getParameter('ads.results_per_page');
        $role = sprintf(
            '%%%s%%',
            $this->get('aamv_site.role_retriever')->getRoleFromName($type)
        );

        $options = array('role' => array('value' => $role));

        if ($city !== 'none') {
            $options['city'] = array(
                'value' => $city
            );

            if ($neighborhood !== 'none') {
                $options['neighborhood'] = array(
                    'value' => $neighborhood
                );
            }
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
        $results['cities'] = $this->getRepository('AamvSiteBundle:User')->getCities($role);

        $results['neighborhood'] = $neighborhood;
        $results['neighborhoods'] = $this->getRepository('AamvSiteBundle:User')->getNeighborhoods($role);

        $results['pagination']['route'] = 'aamv_site_services_ads_list';
        $results['pagination']['parameters'] = array(
            'type' => $type,
            'city' => $city
        );

        return $this->render(
            'AamvSiteBundle:Services:list_ad.html.twig',
            $results
        );
    }

    public function showAdAction($id)
    {
        $ad = $this->getEntityManager()
            ->getRepository('AamvSiteBundle:Ad')
            ->find($id);

        if (null === $this->getUser() || ($ad->getAuthor()->getId() !== $this->getUser()->getId())) {
            $ad->addView();

            $this->getEntityManager()
                ->flush();
        }

        if ($ad === null) {
            return $this->redirectToUrl('aamv_site_homepage');
        }

        return $this->render(
            'AamvSiteBundle:Services:ad.html.twig',
            array('ad' => $ad)
        );
    }

    public function disponibilitiesAction()
    {
        return $this->render('AamvSiteBundle:Services:disponibilites.html.twig');
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
}
