<?php

namespace AppBundle\Service\EventListener;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ConsentRedirectListener
{
    private $tokenStorage;
    private $router;

    public function __construct(TokenStorageInterface $tokenStorage, RouterInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $token = $this->tokenStorage->getToken();
        if (null === $token) {
            return;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return;
        }

        if (null !== $user->getConsentedAt()) {
            return;
        }

        $allowedRoutes = [
            'manage_consent',
            'association_privacy',
            'logout',
        ];

        $route = $event->getRequest()->attributes->get('_route');
        if (in_array($route, $allowedRoutes, true)) {
            return;
        }

        $url = $this->router->generate('manage_consent');
        $event->setResponse(new RedirectResponse($url));
    }
}
