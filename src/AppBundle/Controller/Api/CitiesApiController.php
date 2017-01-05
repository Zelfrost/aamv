<?php

namespace AppBundle\Controller\Api;

use Buzz\Browser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CitiesApiController extends Controller
{
    /**
     * @Route(path="/api/cities/get/{name}", options={"expose" = true}, name="api_cities")
     */
    public function getAction($name)
    {
        $cities = $this->get('retriever.city')->retrieve($name);

        return new JsonResponse($cities);
    }
}
