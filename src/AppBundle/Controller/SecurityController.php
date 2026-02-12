<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Disponibility;
use AppBundle\Entity\Person;
use AppBundle\Entity\User;
use AppBundle\Form\Type\ChangePasswordType;
use AppBundle\Form\Type\ForgotPasswordType;
use AppBundle\Form\Type\LoginType;
use AppBundle\Form\Type\RegisterType;
use AppBundle\Form\Type\ReinitPasswordType;
use AppBundle\Service\Mailer\ForgotPasswordMailer;
use AppBundle\Service\Mailer\RegistrationMailer;
use AppBundle\Service\Retriever\RoleRetriever;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private ManagerRegistry $doctrine;
    private UserPasswordHasherInterface $passwordHasher;
    private AuthenticationUtils $authenticationUtils;
    private RoleRetriever $roleRetriever;
    private RegistrationMailer $registrationMailer;
    private ForgotPasswordMailer $forgotPasswordMailer;

    public function __construct(
        ManagerRegistry $doctrine,
        UserPasswordHasherInterface $passwordHasher,
        AuthenticationUtils $authenticationUtils,
        RoleRetriever $roleRetriever,
        RegistrationMailer $registrationMailer,
        ForgotPasswordMailer $forgotPasswordMailer
    ) {
        $this->doctrine = $doctrine;
        $this->passwordHasher = $passwordHasher;
        $this->authenticationUtils = $authenticationUtils;
        $this->roleRetriever = $roleRetriever;
        $this->registrationMailer = $registrationMailer;
        $this->forgotPasswordMailer = $forgotPasswordMailer;
    }

    /**
     * @Route(path="/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->doctrine->getManager();
            $alreadyExistingPerson = $em
                ->getRepository(Person::class)
                ->findPersonOnly($user->getEmail())
            ;
            if (null !== $alreadyExistingPerson && $alreadyExistingPerson instanceof Person) {
                $disponibilities = [];

                /** @var Disponibility $disponibility */
                foreach ($alreadyExistingPerson->getDisponibilities() as $disponibility) {
                    $disponibilities[] = $disponibility;
                    $disponibility->setChildminder(null);
                }

                $em->remove($alreadyExistingPerson);
                $em->flush();

                foreach ($disponibilities as $disponibility) {
                    $disponibility->setChildminder($user);
                }
            }

            $user->setConsentedAt(new \DateTime());

            $role = $this->roleRetriever->getRoleFromName($form->get('role')->getData());
            $user->addRole($role);

            $this->registrationMailer->send($user);

            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                "Votre compte a bien été créé. Vous allez recevoir un email de confirmation d'ici quelques minutes."
            );

            return $this->redirect($this->generateUrl('login'));
        }

        return $this->render(
            '@AppBundle/Security/register.html.twig',
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

        $form = $this->createForm(LoginType::class);

        return $this->render(
            '@AppBundle/Security/login.html.twig',
            array(
                'title' => 'Connexion',
                'form' => $form->createView(),
                'error' => $this->authenticationUtils->getLastAuthenticationError(),
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

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->doctrine
                ->getRepository(User::class)
                ->findOneByEmail($form->get('email')->getData())
            ;

            if (null === $user) {
                $error = "Aucun compte n'est lié à cette adresse email";
            } elseif (null !== $user->getPasswordReinitializationCode() && !$user->isPasswordReinitializationCodeExpired()) {
                $error = "Une demande de réinitialisation de mot de passe a déjà été faite pour ce compte.";
            } else {
                $expiresAt = new \DateTime();
                $expiresAt->modify('+1 hour');

                $user->setPasswordReinitializationCode(md5(uniqid($user->getId(), true)));
                $user->setPasswordReinitializationCodeExpiresAt($expiresAt);

                $this->doctrine->getManager()->flush();

                $this->forgotPasswordMailer->send($user);

                $request->getSession()->getFlashBag()->add(
                    'success',
                    'Un email vient de vous être envoyé afin de ré-initialiser votre mot de passe'
                );

                return $this->redirectToRoute('login');
            }
        }

        return $this->render('@AppBundle/Security/forgot_password.html.twig', array(
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

        $user = $this->doctrine
            ->getRepository(User::class)
            ->findOneByPasswordReinitializationCode($code)
        ;

        if ($user === null) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        if ($user->isPasswordReinitializationCodeExpired()) {
            $user->setPasswordReinitializationCode(null);
            $user->setPasswordReinitializationCodeExpiresAt(null);
            $this->doctrine->getManager()->flush();

            $request->getSession()->getFlashBag()->add(
                'error',
                'Ce lien de réinitialisation a expiré. Veuillez faire une nouvelle demande.'
            );

            return $this->redirectToRoute('forgot_password');
        }

        $form = $this->createForm(ReinitPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPasswordReinitializationCode(null);
            $user->setPasswordReinitializationCodeExpiresAt(null);
            $user->setLegacyPassword(null);
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $user->getPlainPassword()
            ));

            $this->doctrine->getManager()->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Votre mot de passe a bien été modifié.'
            );

            return $this->redirectToRoute('login');
        }

        return $this->render('@AppBundle/Security/reinit_password.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
