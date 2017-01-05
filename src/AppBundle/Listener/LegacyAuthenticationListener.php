<?php

namespace AppBundle\Listener;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LegacyAuthenticationListener
{
    /**
     * @var TokenStorageInterface
     */
    private $security;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserPasswordEncoder
     */
    private $encoder;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param Session $session
     * @param UserPasswordEncoder $encoder
     * @param Registry $registry
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        Session $session,
        UserPasswordEncoder $encoder,
        Registry $registry
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->encoder = $encoder;
        $this->registry = $registry;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user->isLegacy()) {
            $this->session->getFlashBag()->add('authentication.legacy', true);
            $password = $event->getRequest()->get('login')['_password'];

            $user->setLegacyPassword(null);
            $user->setPassword($this->encoder->encodePassword($user, $password));

            $this->registry
                ->getManager()
                ->flush();
        }
    }
}
