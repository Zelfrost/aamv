<?php

namespace AppBundle\Controller\Api;

use AppBundle\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CitiesApiController extends AbstractController
{
    private $repository;

    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route(path: '/api/cities/get/{name}', name: 'api_cities', options: ['expose' => true])]
    public function getAction($name)
    {
        return new JsonResponse($this->repository->findLike($name));
    }
}
