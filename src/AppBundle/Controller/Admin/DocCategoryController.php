<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Category;
use AppBundle\Entity\Tool;
use AppBundle\Form\Type\CategoryType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DocCategoryController extends Controller
{
    /**
     * @Route(path="/admin/doc_categories", name="admin_doc_categories")
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOrdered(Tool::DOC_TYPE)
        ;

        return $this->render('AppBundle:Admin:DocCategories/index.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route(path="/admin/doc_categories/create", name="admin_doc_categories_create")
     * @Method({"GET", "POST"})
     */
    public function createCategoryAction(Request $request)
    {
        $type = new Category();
        $type->setType(Tool::DOC_TYPE);

        $form = $this->createForm(CategoryType::class, $type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->persist($type);

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.categories.success', 'La catégorie a bien été ajoutée.');

            return $this->redirect($this->generateUrl('admin_doc_categories'));
        }

        return $this->render('AppBundle:Admin:DocCategories/create.html.twig', array(
            'type' => $type,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/doc_categories/edit/{id}", name="admin_doc_categories_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $type)
    {
        $form = $this->createForm(CategoryType::class, $type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.categories.success', 'La catégorie a bien été mise à jour.');

            return $this->redirect($this->generateUrl('admin_doc_categories'));
        }

        return $this->render('AppBundle:Admin:DocCategories/edit.html.twig', array(
            'tool' => $type,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/doc_categories/delete/{id}", name="admin_doc_categories_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Category $type)
    {
        $this->getDoctrine()
            ->getManager()
            ->remove($type)
        ;

        try {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.categories.success', 'La catégorie a bien été supprimée.');
        } catch (ForeignKeyConstraintViolationException $e) {
            $this->get('session')->getFlashBag()->add(
                'admin.categories.error',
                'Impossible de supprimer une catégorie à laquelle des documents sont liées.'
            );
        }

        return $this->redirect($this->generateUrl('admin_doc_categories'));
    }
}
