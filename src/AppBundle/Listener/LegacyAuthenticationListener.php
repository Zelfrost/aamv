<?php

namespace AppBundle\Listener;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LegacyAuthenticationListener
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var UserPasswordHasherInterface
     */
    private $hasher;

    /**
     * @var Registry
     */
    private $registry;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        RequestStack $requestStack,
        UserPasswordHasherInterface $hasher,
        Registry $registry
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
        $this->hasher = $hasher;
        $this->registry = $registry;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user->isLegacy()) {
            $this->requestStack->getSession()->getFlashBag()->add('authentication.legacy', true);
            $password = $event->getRequest()->get('login')['_password'];

            $user->setLegacyPassword(null);
            $user->setPassword($this->hasher->hashPassword($user, $password));

            $this->registry
                ->getManager()
                ->flush();
        }
    }
}
