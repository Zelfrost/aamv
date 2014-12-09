<?php

namespace Aamv\Bundle\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbstractController extends Controller
{
    public function persistAndFlush($entity)
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $em->persist($entity);
        $em->flush();
    }
}
