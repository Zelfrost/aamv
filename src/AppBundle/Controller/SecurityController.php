<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\ChangePasswordType;
use AppBundle\Form\Type\ForgotPasswordType;
use AppBundle\Form\Type\LoginType;
use AppBundle\Form\Type\RegisterType;
use AppBundle\Form\Type\ReinitPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
            $user->setFromIP($request->getClientIp());

            $this->get('mailer.registration')->send($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
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

    /**
     * @Route(path="/forgot_password", name="forgot_password")
     */
    public function forgotPasswordAction(Request $request)
    {
        if ($this->getUser() !== null) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        $error = null;

        if ($form->isValid()) {
            /** @var User $user */
            $user = $this
                ->getDoctrine()
                ->getRepository(User::class)
                ->findOneByEmail($form->get('email')->getData())
            ;

            if ($user !== null) {
                $user->setPasswordReinitializationCode(md5(uniqid($user->getId(), true)));

                $this->getDoctrine()->getManager()->flush();

                $this->get('mailer.forgot_password')->send($user);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Un email vient de vous être envoyé afin de ré-initialiser votre mot de passe'
                );

                return $this->redirectToRoute('login');
            }

            $error = "Aucun compte n'est lié à cette adresse email";
        }

        return $this->render('AppBundle:Security:forgot_password.html.twig', array(
            'form' => $form->createView(),
            'error' => $error
        ));
    }

    /**
     * @Route(path="/reinit_password/{code}", name="reinit_password")
     */
    public function reinitPasswordAction($code, Request $request)
    {
        if ($this->getUser() !== null) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findOneByPasswordReinitializationCode($code)
        ;

        if ($user === null) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        $form = $this->createForm(ReinitPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setPasswordReinitializationCode(null);
            $user->setLegacyPassword(null);
            $user->setPassword($this->get('security.password_encoder')->encodePassword(
                $user,
                $user->getPlainPassword()
            ));

            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre mot de passe a bien été modifié.'
            );

            return $this->redirectToRoute('login');
        }

        return $this->render('AppBundle:Security:reinit_password.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
