<?php

namespace AppBundle\Controller\Api;

use AppBundle\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CitiesApiController extends Controller
{
    private $repository;

    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route(path="/api/cities/get/{name}", options={"expose" = true}, name="api_cities")
     */
    public function getAction($name)
    {
        return new JsonResponse($this->repository->findLike($name));
    }
}
