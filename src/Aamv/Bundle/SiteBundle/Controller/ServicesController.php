<?php

namespace Aamv\Bundle\SiteBundle\Controller;

use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class ServicesController extends AbstractController
{
    public function adsAction($page)
    {
        $resultsPerPage = $this->container->getParameter('ads.results_per_page');

        $results = $this->get('aamv_site.ads.ads_finder')->getAds($page, $resultsPerPage);
        $results['pagination']['route'] = 'aamv_site_ads';

        return $this->render(
            'AamvSiteBundle:Services:ads.html.twig',
            $results
        );
    }

    public function adAction($id)
    {
        $ad = $this->getDoctrine()
            ->getRepository('AamvSiteBundle:Ads')
            ->findOneById($id);

        return $this->render(
            'AamvSiteBundle:Services:ad.html.twig',
            array('ad' => $ad)
        );
    }

    public function outilsAction()
    {
        return $this->render('AamvSiteBundle:Services:outils.html.twig');
    }

    public function questionsReponsesAction()
    {
        return $this->render('AamvSiteBundle:Services:questions_reponses.html.twig');
    }
}
