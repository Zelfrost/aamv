<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Category;
use AppBundle\Entity\Tool;
use AppBundle\Form\Type\CategoryType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ToolCategoryController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route(path="/admin/tool_categories", name="admin_tool_categories")
     */
    public function indexAction()
    {
        $categories = $this->doctrine
            ->getRepository(Category::class)
            ->findOrdered(Tool::TOOL_TYPE)
        ;

        return $this->render('@AppBundle/Admin/ToolCategories/index.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route(path="/admin/tool_categories/create", name="admin_tool_categories_create", methods={"GET", "POST"})
     */
    public function createCategoryAction(Request $request)
    {
        $type = new Category();
        $type->setType(Tool::TOOL_TYPE);

        $form = $this->createForm(CategoryType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine
                ->getManager()
                ->persist($type);

            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('admin.categories.success', "La catégorie a bien été ajoutée.");

            return $this->redirect($this->generateUrl('admin_tool_categories'));
        }

        return $this->render('@AppBundle/Admin/ToolCategories/create.html.twig', array(
            'type' => $type,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/tool_categories/edit/{id}", name="admin_tool_categories_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Category $type)
    {
        $form = $this->createForm(CategoryType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('admin.categories.success', "La catégorie a bien été mise à jour.");

            return $this->redirect($this->generateUrl('admin_tool_categories'));
        }

        return $this->render('@AppBundle/Admin/ToolCategories/edit.html.twig', array(
            'tool' => $type,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/tool_categories/delete/{id}", name="admin_tool_categories_delete", methods={"DELETE"})
     */
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

            $request->getSession()->getFlashBag()->add('admin.categories.success', "La catégorie a bien été supprimée.");
        } catch (ForeignKeyConstraintViolationException $e) {
            $request->getSession()->getFlashBag()->add(
                'admin.categories.error',
                'Impossible de supprimer une catégorie à laquelle des outils sont liées.'
            );
        }

        return $this->redirect($this->generateUrl('admin_tool_categories'));
    }
}
