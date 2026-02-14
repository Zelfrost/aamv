<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route(path: '/admin/users/{page}', name: 'admin_users')]
    public function indexAction(Request $request, $page = 1)
    {
        $email = $request->query->get('email');
        $role = $request->query->get('role');

        $users = $this->doctrine
            ->getRepository(User::class)
            ->search($email, $role, $page)
        ;

        return $this->render('@AppBundle/Admin/User/index.html.twig', array(
            'users' => $users,
            'pagination' => [
                'route' => 'admin_users',
                'page' => $page,
                'role' => $role,
                'email' => $email,
                'pages_count' => ceil($users->count() / 30),
                'parameters' => ['role' => $role, 'email' => $email]
            ]
        ));
    }

    #[Route(path: '/admin/user/delete/{id}', name: 'admin_user_delete', methods: ['DELETE'])]
    public function deleteAction(User $user, Request $request)
    {
        $this->doctrine
            ->getManager()
            ->remove($user);

        $this->doctrine
            ->getManager()
            ->flush();

        $request->getSession()->getFlashBag()->add('admin.user.success', "L'utilisateur a bien été supprimé.");

        return $this->redirect($this->generateUrl('admin_users', [
            'role' => $request->request->get('role'),
            'page' => $request->request->get('page'),
        ]));
    }

    #[Route(path: '/admin/user/change/{id}', name: 'admin_user_change', methods: ['PUT'])]
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

        $this->doctrine
            ->getManager()
            ->flush();

        $request->getSession()->getFlashBag()->add('admin.user.success', "L'utilisateur a bien été modifié.");

        return $this->redirect($this->generateUrl('admin_users', [
            'role' => $request->request->get('role'),
            'page' => $request->request->get('page'),
        ]));
    }
}
