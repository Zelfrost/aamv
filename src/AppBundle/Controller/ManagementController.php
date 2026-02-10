<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ad;
use AppBundle\Entity\Disponibility;
use AppBundle\Form\Type\AdType;
use AppBundle\Form\Type\ChangePasswordType;
use AppBundle\Form\Type\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ManagementController extends Controller
{
    /**
     * @Route(path="/manage/consent", name="manage_consent")
     */
    public function consentAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $user = $this->getUser();
            $user->setConsentedAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add('success', 'Merci, votre consentement a bien été enregistré.');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Management:consent.html.twig');
    }

    /**
     * @Route(path="/manage/password", name="manage_password")
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);


        if (!$form->isValid()) {
            return $this->render('AppBundle:Management:password.html.twig', array(
                'form' => $form->createView()
            ));
        }

        $password = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $this->getDoctrine()
            ->getManager()
            ->flush();

        $this->get('session')->getFlashBag()->add(
            'management.legacy_password.success',
            'Votre nouveau mot de passe a bien été enregistré'
        );

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route(path="/manage/account", options={"expose" = true}, name="manage_account")
     */
    public function accountAction(Request $request)
    {
        $form = $this->createForm(ProfileType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->get('session')->getFlashBag()->add('management.account.success', "Votre compte a bien été modifié.");
        }

        return $this->render('AppBundle:Management:account.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/manage/ads", name="manage_ads")
     */
    public function adsAction()
    {
        $ads = $this->getDoctrine()
            ->getManager()
            ->getRepository(Ad::class)
            ->findByAuthor($this->getUser());

        return $this->render('AppBundle:Management:ads.html.twig', array(
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

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($ad);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('management.ads.success', "Votre annonce a bien été crée.");

            return $this->redirect($this->generateUrl('manage_ads'));
        }

        return $this->render(
            'AppBundle:Management:create_ad.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route(path="/manage/ad/edit/{id}", name="manage_ad_edit")
     */
    public function editAdAction(Request $request, Ad $ad = null)
    {
        $session = $this->get("session");

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

        if ($form->isValid()) {
            if ($form->has('revalidate') && $form->get('revalidate')->isClicked()) {
                $ad->setCreatedAt(new \DateTime());
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($ad);
            $manager->flush();

            $session->getFlashBag()->add('management.ads.success', "Votre annonce a bien été modifiée.");

            return $this->redirectToRoute('manage_ad_edit', ['id' => $ad->getId()]);
        }

        return $this->render('AppBundle:Management:edit_ad.html.twig', array(
            'ad' => $ad,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(path="/manage/ad/delete/{id}", name="manage_ad_delete")
     */
    public function deleteAdAction(Ad $ad = null)
    {
        $session = $this->get("session");

        if (null === $ad) {
            $session->getFlashBag()->add('management.ads.error', "Cette annonce n'existe pas.");
        } else {
            if ($this->getUser()->getId() !== $ad->getAuthor()->getId()) {
                $session->getFlashBag()->add('management.ads.error', "Cette annonce ne vous appartient pas.");
            } else {
                $this->getDoctrine()
                    ->getManager()
                    ->remove($ad);
                $this->getDoctrine()
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
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $ads = $em->getRepository(Ad::class)->findByAuthor($user);
        foreach ($ads as $ad) {
            $em->remove($ad);
        }

        $disponibilities = $em->getRepository(Disponibility::class)->findBy(['childminder' => $user]);
        foreach ($disponibilities as $disponibility) {
            $em->remove($disponibility);
        }

        $em->remove($user);
        $em->flush();

        $this->get('security.token_storage')->setToken(null);
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
        $em = $this->getDoctrine()->getManager();

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
