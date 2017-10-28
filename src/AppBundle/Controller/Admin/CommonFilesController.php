<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\Type\CommonFileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommonFilesController extends Controller
{
    /**
     * @Route(path="/admin/files/join", name="admin_files_join")
     * @Method({"GET", "POST"})
     */
    public function joinAction(Request $request)
    {
        $form = $this->createForm(CommonFileType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $file = $data['file'];

            $file->move(__DIR__.'/../../../../web/public/', 'adhesion-formulaire.docx');

            $this->get('session')->getFlashBag()->add('admin.success', "Le formulaire d'adhésion a bien été remplacé.");

            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('AppBundle:Admin:CommonFiles/join.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/files/disponibility", name="admin_files_disponibility")
     * @Method({"GET", "POST"})
     */
    public function disponibilityAction(Request $request)
    {
        $form = $this->createForm(CommonFileType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $file = $data['file'];

            $file->move(__DIR__.'/../../../../web/public/', 'disponibilites.doc');

            $this->get('session')->getFlashBag()->add('admin.success', "Le formulaire de disponibilité a bien été remplacé.");

            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('AppBundle:Admin:CommonFiles/disponibility.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
