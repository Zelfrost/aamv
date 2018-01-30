<?php

namespace AppBundle\Service\Mailer;

use AppBundle\Entity\User;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class ForgotPasswordMailer implements LoggerAwareInterface
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

    /**
     * @var string
     */
    private $baseUrl;

    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer, $baseUrl)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->baseUrl = $baseUrl;
    }

    public function send(User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('AAMV - Ré-initialiser votre mot de passe')
            ->setFrom('forgot_password@aamv.net', 'AAMV')
            ->setTo($user->getEmail())
            ->setBody($this->twig->render('emails/forgot_password.html.twig', array(
                'user' => $user,
                'base_url' => $this->baseUrl,
            )), 'text/html')
        ;

        try {
            $this->mailer->send($message);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
