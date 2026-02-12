<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ad;
use AppBundle\Entity\Disponibility;
use AppBundle\Entity\News;
use AppBundle\Form\Type\AdType;
use AppBundle\Form\Type\ChangePasswordType;
use AppBundle\Form\Type\ProfileType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ManagementController extends AbstractController
{
    private ManagerRegistry $doctrine;
    private UserPasswordHasherInterface $passwordHasher;
    private TokenStorageInterface $tokenStorage;

    public function __construct(
        ManagerRegistry $doctrine,
        UserPasswordHasherInterface $passwordHasher,
        TokenStorageInterface $tokenStorage
    ) {
        $this->doctrine = $doctrine;
        $this->passwordHasher = $passwordHasher;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route(path="/manage/consent", name="manage_consent")
     */
    public function consentAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('consent', $request->request->get('_token'))) {
                throw $this->createAccessDeniedException('Jeton CSRF invalide.');
            }

            $user = $this->getUser();
            $user->setConsentedAt(new \DateTime());

            $this->doctrine->getManager()->flush();

            $request->getSession()->getFlashBag()->add('success', 'Merci, votre consentement a bien été enregistré.');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('@AppBundle/Management/consent.html.twig');
    }

    /**
     * @Route(path="/manage/password", name="manage_password")
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add(
                'management.legacy_password.success',
                'Votre nouveau mot de passe a bien été enregistré'
            );

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('@AppBundle/Management/password.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/manage/account", options={"expose" = true}, name="manage_account")
     */
    public function accountAction(Request $request)
    {
        $form = $this->createForm(ProfileType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine
                ->getManager()
                ->flush();

            $request->getSession()->getFlashBag()->add('management.account.success', "Votre compte a bien été modifié.");
        }

        return $this->render('@AppBundle/Management/account.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/manage/ads", name="manage_ads")
     */
    public function adsAction()
    {
        $ads = $this->doctrine
            ->getManager()
            ->getRepository(Ad::class)
            ->findByAuthor($this->getUser());

        return $this->render('@AppBundle/Management/ads.html.twig', array(
            'ads' => $ads
        ));
    }

    /**
     * @Route(path="/manage/ad/create", name="manage_ad_create")
     */
    public function createAdAction(Request $request)
    {
        $ad = new Ad();
        $ad->setAuthor($this->getUser());

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->doctrine->getManager();
            $manager->persist($ad);
            $manager->flush();

            $request->getSession()->getFlashBag()->add('management.ads.success', "Votre annonce a bien été crée.");

            return $this->redirect($this->generateUrl('manage_ads'));
        }

        return $this->render(
            '@AppBundle/Management/create_ad.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route(path="/manage/ad/edit/{id}", name="manage_ad_edit")
     */
    public function editAdAction(Request $request, ?Ad $ad = null)
    {
        $session = $request->getSession();

        if ($this->getUser()->getId() !== $ad->getAuthor()->getId()) {
            $session->getFlashBag()->add('management.ads.error', "Cette annonce ne vous appartient pas.");

            return $this->redirect($this->generateUrl('manage_ads'));
        }

        if (null === $ad) {
            $session->getFlashBag()->add('management.ads.error', "Cette annonce n'existe pas.");

            return $this->redirect($this->generateUrl('manage_ads'));
        }

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->has('revalidate') && $form->get('revalidate')->isClicked()) {
                $ad->setCreatedAt(new \DateTime());
            }

            $manager = $this->doctrine->getManager();
            $manager->persist($ad);
            $manager->flush();

            $session->getFlashBag()->add('management.ads.success', "Votre annonce a bien été modifiée.");

            return $this->redirectToRoute('manage_ad_edit', ['id' => $ad->getId()]);
        }

        return $this->render('@AppBundle/Management/edit_ad.html.twig', array(
            'ad' => $ad,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/manage/ad/delete/{id}", name="manage_ad_delete")
     */
    public function deleteAdAction(Request $request, ?Ad $ad = null)
    {
        $session = $request->getSession();

        if (null === $ad) {
            $session->getFlashBag()->add('management.ads.error', "Cette annonce n'existe pas.");
        } else {
            if ($this->getUser()->getId() !== $ad->getAuthor()->getId()) {
                $session->getFlashBag()->add('management.ads.error', "Cette annonce ne vous appartient pas.");
            } else {
                $this->doctrine
                    ->getManager()
                    ->remove($ad);
                $this->doctrine
                    ->getManager()
                    ->flush();

                $session->getFlashBag()->add('management.ads.success', "Votre annonce a bien été supprimée.");
            }
        }

        return $this->redirect($this->generateUrl('manage_ads'));
    }

    /**
     * @Route(path="/manage/account/delete", name="manage_account_delete", methods={"POST"})
     */
    public function deleteAccountAction(Request $request)
    {
        if (!$this->isCsrfTokenValid('delete_account', $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $user = $this->getUser();
        $em = $this->doctrine->getManager();

        $ads = $em->getRepository(Ad::class)->findByAuthor($user);
        foreach ($ads as $ad) {
            $em->remove($ad);
        }

        $news = $em->getRepository(News::class)->findByAuthor($user);
        foreach ($news as $item) {
            $em->remove($item);
        }

        $disponibilities = $em->getRepository(Disponibility::class)->findBy(['childminder' => $user]);
        foreach ($disponibilities as $disponibility) {
            $em->remove($disponibility);
        }

        $em->remove($user);
        $em->flush();

        $this->tokenStorage->setToken(null);
        $request->getSession()->invalidate();
        $request->getSession()->getFlashBag()->add('success', 'Votre compte a été supprimé avec succès.');

        return $this->redirectToRoute('login');
    }

    /**
     * @Route(path="/manage/account/export", name="manage_account_export")
     */
    public function exportDataAction()
    {
        $user = $this->getUser();
        $em = $this->doctrine->getManager();

        $data = [
            'informations_personnelles' => [
                'nom' => $user->getName(),
                'prenom' => $user->getFirstname(),
                'email' => $user->getEmail(),
                'telephone' => $user->getPhoneNumber(),
                'ville' => $user->getCity(),
                'quartier' => $user->getNeighborhood(),
            ],
            'compte' => [
                'roles' => $user->getRoles(),
                'date_creation' => $user->getCreatedAt() ? $user->getCreatedAt()->format('Y-m-d H:i:s') : null,
                'date_consentement' => $user->getConsentedAt() ? $user->getConsentedAt()->format('Y-m-d H:i:s') : null,
            ],
            'annonces' => [],
            'disponibilites' => [],
        ];

        $ads = $em->getRepository(Ad::class)->findByAuthor($user);
        foreach ($ads as $ad) {
            $data['annonces'][] = [
                'titre' => $ad->getTitle(),
                'contenu' => $ad->getContent(),
                'type' => $ad->getType(),
                'date_creation' => $ad->getCreatedAt() ? $ad->getCreatedAt()->format('Y-m-d H:i:s') : null,
                'date_modification' => $ad->getUpdatedAt() ? $ad->getUpdatedAt()->format('Y-m-d H:i:s') : null,
                'jours_souhaites' => $ad->getWishedDays(),
            ];
        }

        $disponibilities = $em->getRepository(Disponibility::class)->findBy(['childminder' => $user]);
        foreach ($disponibilities as $disponibility) {
            $data['disponibilites'][] = [
                'nombre_enfants' => $disponibility->getNumberOfChildren(),
                'periode' => $disponibility->getPeriod(),
            ];
        }

        $response = new JsonResponse($data, 200, [
            'Content-Disposition' => 'attachment; filename="mes-donnees-aamv.json"',
        ]);

        return $response;
    }
}
