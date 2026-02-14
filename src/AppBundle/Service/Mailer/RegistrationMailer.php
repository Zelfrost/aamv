<?php

namespace AppBundle\Service\Mailer;

use AppBundle\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class RegistrationMailer
{
    private $twig;
    private $mailer;

    public function __construct(Environment $twig, MailerInterface $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function send(User $user)
    {
        $message = (new Email())
            ->from(new Address('registration@aamv.net', 'AAMV'))
            ->to($user->getEmail())
            ->subject('Bienvenue sur le site de l\'AAMV')
            ->html($this->twig->render('emails/registration.html.twig', ['user' => $user]))
        ;

        try {
            $this->mailer->send($message);
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }
}
