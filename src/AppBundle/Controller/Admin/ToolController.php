<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Tool;
use AppBundle\Form\Type\ToolType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ToolController extends Controller
{
    /**
     * @Route(path="/admin/tools", name="admin_tools")
     */
    public function indexAction()
    {
        $tools = $this->getDoctrine()
            ->getRepository(Tool::class)
            ->findAll();

        return $this->render('AppBundle:Admin:Tools/index.html.twig', array(
            'tools' => $tools
        ));
    }

    /**
     * @Route(path="/admin/tools/create", name="admin_tools_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $tool = new Tool();

        $form = $this->createForm(ToolType::class, $tool);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $tool->upload();

            $this->getDoctrine()
                ->getManager()
                ->persist($tool);

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.tools.success', "L'outil a bien été ajouté.");

            return $this->redirect($this->generateUrl('admin_tools'));
        }

        return $this->render('AppBundle:Admin:Tools/create.html.twig', array(
            'tool' => $tool,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/tools/edit/{id}", name="admin_tools_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tool $tool)
    {
        $form = $this->createForm(ToolType::class, $tool);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $tool->upload();

            $tool->setUpdatedAt(new \DateTime());

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.tools.success', "L'outil a bien été mis à jour.");

            return $this->redirect($this->generateUrl('admin_tools'));
        }

        return $this->render('AppBundle:Admin:Tools/edit.html.twig', array(
            'tool' => $tool,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/tools/delete/{id}", name="admin_tools_delete")
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

        $this->get('session')->getFlashBag()->add('admin.tools.success', "L'outil a bien été supprimée.");

        return $this->redirect($this->generateUrl('admin_tools'));
    }
}
