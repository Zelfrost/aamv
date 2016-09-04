<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route(path="/admin/users", name="admin_users")
     */
    public function indexAction()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('AppBundle:Admin:User/index.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route(path="/admin/user/delete/{id}", name="admin_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(User $user)
    {
        $this->getDoctrine()
            ->getManager()
            ->remove($user);

        $this->getDoctrine()
            ->getManager()
            ->flush();

        $this->get('session')->getFlashBag()->add('admin.user.success', "L'utilisateur a bien été supprimé.");

        return $this->redirect($this->generateUrl('admin_users'));
    }
}
