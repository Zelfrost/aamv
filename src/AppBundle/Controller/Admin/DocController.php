<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Tool;
use AppBundle\Entity\Category;
use AppBundle\Form\Type\ToolType;
use AppBundle\Form\Type\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DocController extends Controller
{
    /**
     * @Route(path="/admin/docs", name="admin_docs")
     */
    public function indexAction()
    {
        $tools = $this->getDoctrine()
            ->getManager()
            ->getRepository(Tool::class)
            ->findFiles(Tool::DOC_TYPE)
        ;

        $categories = $this->getDoctrine()
            ->getManager()
            ->getRepository(Category::class)
            ->findFiles(Tool::DOC_TYPE)
        ;

        return $this->render('AppBundle:Admin:Docs/index.html.twig', [
            'tools' => $tools,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route(path="/admin/docs/create", name="admin_docs_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $tool = new Tool();
        $tool->setType(Tool::DOC_TYPE);

        $form = $this->createForm(ToolType::class, $tool, ['attr' => ['type' => Tool::DOC_TYPE]]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $tool->upload();

            $this->getDoctrine()
                ->getManager()
                ->persist($tool);

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.docs.success', 'Le document a bien été ajouté.');

            return $this->redirect($this->generateUrl('admin_docs'));
        }

        return $this->render('AppBundle:Admin:Docs/create.html.twig', array(
            'tool' => $tool,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/docs/edit/{id}", name="admin_docs_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tool $tool)
    {
        $form = $this->createForm(ToolType::class, $tool, ['attr' => ['type' => Tool::DOC_TYPE]]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $tool->upload();

            $tool->setUpdatedAt(new \DateTime());

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.docs.success', 'Le document a bien été mis à jour.');

            return $this->redirect($this->generateUrl('admin_docs'));
        }

        return $this->render('AppBundle:Admin:Docs/edit.html.twig', array(
            'tool' => $tool,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/docs/delete/{id}", name="admin_docs_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Tool $tool)
    {
        $this->getDoctrine()
            ->getManager()
            ->remove($tool);

        $this->getDoctrine()
            ->getManager()
            ->flush();

        $this->get('session')->getFlashBag()->add('admin.docs.success', 'Le document a bien été supprimé.');

        return $this->redirect($this->generateUrl('admin_docs'));
    }
}
