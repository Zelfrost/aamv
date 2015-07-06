<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class ServicesController extends AbstractController
{
    public function adsAction($page)
    {
        $resultsPerPage = $this->container->getParameter('ads.results_per_page');

        $results = $this->get('aamv_site.publishables_getter')->get(
            'Ads',
            $page,
            $resultsPerPage
        );

        $results['title']               = 'Petites annonces';
        $results['pagination']['route'] = 'aamv_site_services_ads';

        return $this->render(
            'AamvSiteBundle:Publishables:list.html.twig',
            $results
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
