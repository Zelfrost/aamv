<?php

namespace AppBundle\Service\Retriever;

use AppBundle\Repository\CityRepository;

class CityRetriever
{
    private $repository;

    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function retrieve($name): array
    {
        return $this->repository->findLike($name);
    }

    public function getNeighborhoods(): array
    {
        return [
            'Annappes' => 'Annappes',
            'Ascq' => 'Ascq',
            'Babylone' => 'Babylone',
            'Breucq' => 'Breucq',
            'Chateau' => 'Chateau',
            'Cousinerie' => 'Cousinerie',
            'Flers Bourg' => 'Flers Bourg',
            'Haute Borne' => 'Haute Borne',
            'Hotel de ville' => 'Hotel de ville',
            'Les Pres' => 'Les Pres',
            'Pont de bois' => 'Pont de bois',
            'Recueil' => 'Recueil',
            'Résidence' => 'Résidence',
            'Triolo' => 'Triolo',
        ];
    }
}
