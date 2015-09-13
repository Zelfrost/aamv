<?php

namespace Aamv\Bundle\SiteBundle\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Buzz\Browser;
use Aamv\Bundle\DefaultBundle\Controller\AbstractController;

class CitiesApiController extends AbstractController
{
    public function getAction($name)
    {
        $cities = $this->get('aamv_site.city_retriever')->retrieve($name);

        return new JsonResponse($cities);
    }
}
