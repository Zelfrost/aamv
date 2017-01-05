<?php

namespace AppBundle\Service\Mailer;

use AppBundle\Entity\User;
use Monolog\Logger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class RegistrationMailer implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var \TwigEnvironment
     */
    private $twig;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function send(User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Bienvenue sur le site de l\'AAMV')
            ->setFrom('registration@aamv.net', 'AAMV')
            ->setTo($user->getEmail())
            ->setBody($this->twig->render('emails/registration.html.twig', array('user' => $user)), 'text/html')
        ;

        try {
            $this->mailer->send($message);
        } catch (\Exception $e) {
            die($e->getMessage());
            $this->logger->error($e->getMessage());
        }
    }
}