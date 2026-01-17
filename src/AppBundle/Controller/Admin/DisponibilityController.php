<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Disponibility;
use AppBundle\Entity\Person;
use AppBundle\Form\Type\DisponibilityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DisponibilityController extends Controller
{
    /**
     * @Route(path="/admin/disponibilities", name="admin_disponibilities")
     */
    public function indexAction()
    {
        $disponibilities = $this->getDoctrine()
            ->getRepository(Disponibility::class)
            ->findOrdered();

        return $this->render('AppBundle:Admin:Disponibility/index.html.twig', array(
            'disponibilities' => $disponibilities
        ));
    }

    /**
     * @Route(path="/admin/disponibility/create/{childminder}", name="admin_disponibility_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request, Person $childminder = null)
    {
        $disponibility = new Disponibility();

        if ($childminder !== null) {
            $disponibility->setChildminder($childminder);
        }

        $form = $this->createForm(DisponibilityType::class, $disponibility);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->persist($disponibility);

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.disponibility.success', "La disponibilité a bien été créée.");

            return $this->redirect($this->generateUrl('admin_disponibilities'));
        }

        return $this->render('AppBundle:Admin:Disponibility/create.html.twig', array(
            'disponibility' => $disponibility,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/disponibility/edit/{id}", name="admin_disponibility_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Disponibility $disponibility)
    {
        $form = $this->createForm(DisponibilityType::class, $disponibility);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.disponibility.success', "La disponibilité a bien été mise à jour.");

            return $this->redirect($this->generateUrl('admin_disponibilities'));
        }

        return $this->render('AppBundle:Admin:Disponibility/edit.html.twig', array(
            'disponibility' => $disponibility,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/disponibility/delete/{id}", name="admin_disponibility_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Disponibility $disponibility)
    {
        $this->getDoctrine()
            ->getManager()
            ->remove($disponibility);

        $this->getDoctrine()
            ->getManager()
            ->flush();

        $this->get('session')->getFlashBag()->add('admin.disponibility.success', "La disponibilité a bien été supprimé.");

        return $this->redirect($this->generateUrl('admin_disponibilities'));
    }
}
