<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Person;
use AppBundle\Form\Type\PersonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends Controller
{
    /**
     * @Route(path="/admin/person/create", name="admin_person_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $person = new Person();

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->persist($person);

            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('admin.person.success', "L'assistante maternelle a bien été ajoutée.");

            return $this->redirect($this->generateUrl('admin_disponibility_create', array(
                'childminder' => $person->getId()
            )));
        }

        return $this->render('AppBundle:Admin:Person/create.html.twig', array(
            'news' => $person,
            'form' => $form->createView()
        ));
    }
}
