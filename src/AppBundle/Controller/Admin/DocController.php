<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Tool;
use AppBundle\Entity\Category;
use AppBundle\Form\Type\ToolType;
use AppBundle\Form\Type\CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DocController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route(path="/admin/docs", name="admin_docs")
     */
    public function indexAction()
    {
        $tools = $this->doctrine
            ->getManager()
            ->getRepository(Tool::class)
            ->findFiles(Tool::DOC_TYPE)
        ;

        $categories = $this->doctrine
            ->getManager()
            ->getRepository(Category::class)
            ->findFiles(Tool::DOC_TYPE)
        ;

        return $this->render('@AppBundle/Admin/Docs/index.html.twig', [
            'tools' => $tools,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route(path="/admin/docs/create", name="admin_docs_create", methods={"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $tool = new Tool();
        $tool->setType(Tool::DOC_TYPE);

        $form = $this->createForm(ToolType::class, $tool, ['attr' => ['type' => Tool::DOC_TYPE]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tool->upload();

            $this->doctrine
                ->getManager()
                ->persist($tool);

            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('admin.docs.success', 'Le document a bien été ajouté.');

            return $this->redirect($this->generateUrl('admin_docs'));
        }

        return $this->render('@AppBundle/Admin/Docs/create.html.twig', array(
            'tool' => $tool,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/docs/edit/{id}", name="admin_docs_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Tool $tool)
    {
        $form = $this->createForm(ToolType::class, $tool, ['attr' => ['type' => Tool::DOC_TYPE]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tool->upload();

            $tool->setUpdatedAt(new \DateTime());

            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('admin.docs.success', 'Le document a bien été mis à jour.');

            return $this->redirect($this->generateUrl('admin_docs'));
        }

        return $this->render('@AppBundle/Admin/Docs/edit.html.twig', array(
            'tool' => $tool,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/docs/delete/{id}", name="admin_docs_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Tool $tool)
    {
        $this->doctrine
            ->getManager()
            ->remove($tool);

        $this->doctrine
            ->getManager()
            ->flush();

        $request->getSession()->getFlashBag()->add('admin.docs.success', 'Le document a bien été supprimé.');

        return $this->redirect($this->generateUrl('admin_docs'));
    }
}
