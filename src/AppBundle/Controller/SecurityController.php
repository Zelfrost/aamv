<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\LoginType;
use AppBundle\Form\Type\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route(path="/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $role = $this->get('retriever.role')->getRoleFromName($form->get('role')->getData());
            $user->addRole($role);

            $this->get('mailer.registration')->send($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            $this->get('session')->getFlashBag()->add(
                'admin.register.success',
                "Votre compte a bien été créé. Vous allez recevoir un email de confirmation d'ici quelques minutes."
            );

            return $this->redirect($this->generateUrl('login'));
        }

        return $this->render(
            'AppBundle:Security:register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route(path="/login", name="login")
     */
    public function loginAction(Request $request)
    {
        if ($this->getUser() !== null) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        $form = $this->createForm(LoginType::class);

        return $this->render(
            'AppBundle:Security:login.html.twig',
            array(
                'title' => 'Connexion',
                'form' => $form->createView(),
                'error' => $authenticationUtils->getLastAuthenticationError(),
            )
        );
    }
}
