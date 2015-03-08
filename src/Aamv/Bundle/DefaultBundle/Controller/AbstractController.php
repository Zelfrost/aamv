<?php

namespace Aamv\Bundle\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbstractController extends Controller
{
    public function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }

    public function persistAndFlush($entity)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $em->persist($entity);
        $em->flush();
    }

    public function getRepository($entityName)
    {
        return $this->getDoctrine()
            ->getEntityManager()
            ->getRepository($entityName);
    }
}
