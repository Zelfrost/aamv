<?php

namespace AppBundle\Service\Mailer;

use AppBundle\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ForgotPasswordMailer
{
    private $twig;
    private $mailer;
    private $baseUrl;

    public function __construct(Environment $twig, MailerInterface $mailer, $baseUrl)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->baseUrl = $baseUrl;
    }

    public function send(User $user)
    {
        $message = (new Email())
            ->from(new Address('forgot_password@aamv.net', 'AAMV'))
            ->to($user->getEmail())
            ->subject('AAMV - Ré-initialiser votre mot de passe')
            ->html($this->twig->render('emails/forgot_password.html.twig', [
                'user' => $user,
                'base_url' => $this->baseUrl,
            ]))
        ;

        try {
            $this->mailer->send($message);
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }
}
