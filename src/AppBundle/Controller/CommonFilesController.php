<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tool;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;

class CommonFilesController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route(path: '/files/join', name: 'files_join', methods: ['GET'])]
    public function getJoinAction(Request $request)
    {
        $criterias = [
            'type' => null,
            'name' => Tool::JOIN_NAME,
        ];

        if (null !== $request->query->get('year')) {
            $criterias['year'] = $request->query->get('year');
        }

        /** @var Tool $tool */
        $tool = $this->doctrine
            ->getManager()
            ->getRepository(Tool::class)
            ->findOneBy($criterias)
        ;

        if (null !== $tool) {
            $response = new BinaryFileResponse(new \SplFileInfo($tool->getFullyQualifiedPath()));
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

            return $response;
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/files/terms', name: 'files_terms', methods: ['GET'])]
    public function getTermsAction(Request $request)
    {
        /** @var Tool $tool */
        $tool = $this->doctrine
            ->getManager()
            ->getRepository(Tool::class)
            ->findOneBy([
                'type' => null,
                'name' => Tool::TERMS_NAME,
            ])
        ;

        if (null !== $tool) {
            $response = new BinaryFileResponse(new \SplFileInfo($tool->getFullyQualifiedPath()));
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

            return $response;
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/files/disponibilities', name: 'files_disponibilities', methods: ['GET'])]
    public function getDisponibilitiesAction()
    {
        /** @var Tool $tool */
        $tool = $this->doctrine
            ->getManager()
            ->getRepository(Tool::class)
            ->findOneBy([
                'type' => null,
                'name' => Tool::DISPONIBILITIES_NAME,
            ])
        ;

        if (null !== $tool) {
            $response = new BinaryFileResponse(new \SplFileInfo($tool->getFullyQualifiedPath()));
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

            return $response;
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
