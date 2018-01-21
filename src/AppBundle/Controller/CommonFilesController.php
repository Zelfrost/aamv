<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tool;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class CommonFilesController extends Controller
{
    /**
     * @Route(path="/files/join", name="files_join", methods={"GET"})
     */
    public function getJoinAction()
    {
        /** @var Tool $tool */
        $tool = $this->getDoctrine()
            ->getManager()
            ->getRepository(Tool::class)
            ->findOneBy([
                'type' => null,
                'name' => Tool::JOIN_NAME,
            ])
        ;

        if (null !== $tool) {
            $response = new BinaryFileResponse(new \SplFileInfo($tool->getFullyQualifiedPath()));
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

            return $response;
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route(path="/files/disponibilities", name="files_disponibilities", methods={"GET"})
     */
    public function getDisponibilitiesAction()
    {
        /** @var Tool $tool */
        $tool = $this->getDoctrine()
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