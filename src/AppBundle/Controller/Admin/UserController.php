<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\isGranted;

class UserController extends Controller
{
    /**
     * @Route(
     *     path="/admin/users/{role}/{page}",
     *     options={"expose" = true},
     *     name="admin_users"
     * )
     */
    public function indexAction($role = 'none', $page = 1)
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findByRole($role, $page);

        return $this->render('AppBundle:Admin:User/index.html.twig', array(
            'users' => $users,
            'pagination' => [
                'route' => 'admin_users',
                'page' => $page,
                'role' => $role,
                'pages_count' => ceil($users->count() / 30),
                'parameters' => ['role' => $role]
            ]
        ));
    }

    /**
     * @Route(path="/admin/user/delete/{id}", name="admin_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(User $user, Request $request)
    {
        $this->getDoctrine()
            ->getManager()
            ->remove($user);

        $this->getDoctrine()
            ->getManager()
            ->flush();

        $this->get('session')->getFlashBag()->add('admin.user.success', "L'utilisateur a bien été supprimé.");

        return $this->redirect($this->generateUrl('admin_users', [
            'role' => $request->request->get('role'),
            'page' => $request->request->get('page'),
        ]));
    }

    /**
     * @Route(path="/admin/user/change/{id}", name="admin_user_change")
     * @Method("PUT")
     */
    public function changeAction(User $user, Request $request)
    {
        $roles = $user->getRoles();

        if (!in_array('ROLE_ASSISTANT', $roles)) {
            return $this->redirect($this->generateUrl('admin_users'));
        }

        if (in_array('ROLE_MEMBER', $user->getRoles())) {
            unset($roles[array_search('ROLE_MEMBER', $roles)]);

            $user->setRoles($roles);
        } else {
            $roles[] = 'ROLE_MEMBER';

            $user->setRoles($roles);
        }

        $this->getDoctrine()
            ->getManager()
            ->flush();

        $this->get('session')->getFlashBag()->add('admin.user.success', "L'utilisateur a bien été modifié.");

        return $this->redirect($this->generateUrl('admin_users', [
            'role' => $request->request->get('role'),
            'page' => $request->request->get('page'),
        ]));
    }
}
