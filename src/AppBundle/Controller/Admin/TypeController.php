<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Type;
use AppBundle\Form\Type\TypeType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TypeController extends Controller
{
    /**
     * @Route(path="/admin/types", name="admin_types")
     */
    public function indexAction()
    {
        $types = $this->getDoctrine()
            ->getRepository(Type::class)
            ->findAll();

        return $this->render('AppBundle:Admin:Types/index.html.twig', array(
            'types' => $types
        ));
    }

    /**
     * @Route(path="/admin/types/create", name="admin_types_create")
     * @Method({"GET", "POST"})
     */
    public function createTypeAction(Request $request)
    {
        $type = new Type();

        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->persist($type);

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.tools.success', "La catégorie a bien été ajoutée.");

            return $this->redirect($this->generateUrl('admin_types'));
        }

        return $this->render('AppBundle:Admin:Types/create.html.twig', array(
            'type' => $type,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/types/edit/{id}", name="admin_types_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Type $type)
    {
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.tools.success', "La catégorie a bien été mise à jour.");

            return $this->redirect($this->generateUrl('admin_types'));
        }

        return $this->render('AppBundle:Admin:Types/edit.html.twig', array(
            'tool' => $type,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/types/delete/{id}", name="admin_types_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Type $type)
    {
        $this->getDoctrine()
            ->getManager()
            ->remove($type)
        ;

        try {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.types.success', "La catégorie a bien été supprimée.");
        } catch (ForeignKeyConstraintViolationException $e) {
            $this->get('session')->getFlashBag()->add('admin.types.error', "Impossible de supprimer une catégorie à laquelle des outils sont liées.");
        }


        return $this->redirect($this->generateUrl('admin_types'));
    }
}
