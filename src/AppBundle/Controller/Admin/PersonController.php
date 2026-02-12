<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Person;
use AppBundle\Form\Type\PersonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route(path="/admin/person/create", name="admin_person_create", methods={"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $person = new Person();

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->doctrine
                ->getManager()
                ->persist($person);

            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('admin.person.success', "L'assistante maternelle a bien été ajoutée.");

            return $this->redirect($this->generateUrl('admin_disponibility_create', array(
                'childminder' => $person->getId()
            )));
        }

        return $this->render('@AppBundle/Admin/Person/create.html.twig', array(
            'news' => $person,
            'form' => $form->createView()
        ));
    }
}
