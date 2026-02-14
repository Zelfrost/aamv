<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Category;
use AppBundle\Entity\Tool;
use AppBundle\Form\Type\CategoryType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DocCategoryController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route(path: '/admin/doc_categories', name: 'admin_doc_categories')]
    public function indexAction()
    {
        $categories = $this->doctrine
            ->getRepository(Category::class)
            ->findOrdered(Tool::DOC_TYPE)
        ;

        return $this->render('@AppBundle/Admin/DocCategories/index.html.twig', array(
            'categories' => $categories
        ));
    }

    #[Route(path: '/admin/doc_categories/create', name: 'admin_doc_categories_create', methods: ['GET', 'POST'])]
    public function createCategoryAction(Request $request)
    {
        $type = new Category();
        $type->setType(Tool::DOC_TYPE);

        $form = $this->createForm(CategoryType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine
                ->getManager()
                ->persist($type);

            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('admin.categories.success', 'La catégorie a bien été ajoutée.');

            return $this->redirect($this->generateUrl('admin_doc_categories'));
        }

        return $this->render('@AppBundle/Admin/DocCategories/create.html.twig', array(
            'type' => $type,
            'form' => $form->createView()
        ));
    }

    #[Route(path: '/admin/doc_categories/edit/{id}', name: 'admin_doc_categories_edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, Category $type)
    {
        $form = $this->createForm(CategoryType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('admin.categories.success', 'La catégorie a bien été mise à jour.');

            return $this->redirect($this->generateUrl('admin_doc_categories'));
        }

        return $this->render('@AppBundle/Admin/DocCategories/edit.html.twig', array(
            'tool' => $type,
            'form' => $form->createView()
        ));
    }

    #[Route(path: '/admin/doc_categories/delete/{id}', name: 'admin_doc_categories_delete', methods: ['DELETE'])]
    public function deleteAction(Request $request, Category $type)
    {
        $this->doctrine
            ->getManager()
            ->remove($type)
        ;

        try {
            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('admin.categories.success', 'La catégorie a bien été supprimée.');
        } catch (ForeignKeyConstraintViolationException $e) {
            $request->getSession()->getFlashBag()->add(
                'admin.categories.error',
                'Impossible de supprimer une catégorie à laquelle des documents sont liées.'
            );
        }

        return $this->redirect($this->generateUrl('admin_doc_categories'));
    }
}
