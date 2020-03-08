<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Tool;
use AppBundle\Form\Type\CommonFileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        if (null === $request->query->get('year')) {
            return $this->render('AppBundle:Admin:CommonFiles/join-year.html.twig');
        }

        $form = $this->createForm(CommonFileType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $this->saveFile($data['file'], Tool::JOIN_NAME, $request->query->get('year'));

            $this->get('session')->getFlashBag()->add('admin.success', "Le formulaire d'adhésion a bien été remplacé.");

            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('AppBundle:Admin:CommonFiles/join.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/admin/files/terms", name="admin_files_terms")
     * @Method({"GET", "POST"})
     */
    public function termsAction(Request $request)
    {
        $form = $this->createForm(CommonFileType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $this->saveFile($data['file'], Tool::TERMS_NAME);

            $this->get('session')->getFlashBag()->add('admin.success', "Les conditions d'utilisation ont bien été remplacées.");

            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('AppBundle:Admin:CommonFiles/terms.html.twig', array(
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
            $this->saveFile($data['file'], Tool::DISPONIBILITIES_NAME);

            $this->get('session')->getFlashBag()->add('admin.success', "Le formulaire de disponibilité a bien été remplacé.");

            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('AppBundle:Admin:CommonFiles/disponibility.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function saveFile(UploadedFile $file, $name, $year = null)
    {
        $manager = $this->getDoctrine()->getManager();

        $criterias = [
            'type' => null,
            'name' => $name,
        ];

        if (null !== $year) {
            $criterias['year'] = $year;
        }

        $tool = $manager
            ->getRepository(Tool::class)
            ->findOneBy($criterias)
        ;

        if (null === $tool) {
            $tool = new Tool();
            $tool->setName($name);
        }

        if (null !== $year) {
            $tool->setYear($year);
        }

        $tool->setFile($file);
        $tool->upload();

        $manager->persist($tool);
        $manager->flush();
    }
}
