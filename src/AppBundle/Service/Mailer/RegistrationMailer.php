<?php

namespace AppBundle\Service\Mailer;

use AppBundle\Entity\User;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class RegistrationMailer implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var MailerInterface
     */
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
            $this->logger->error($e->getMessage());
        }
    }
}
