<?php

namespace AppBundle\Service\Mailer;

use AppBundle\Entity\User;
use AppBundle\Service\Mailer\RegistrationMailer;
use Mockery as m;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class RegistrationMailerTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    public function testSend()
    {
        $user = new User();
        $user->setName('Somename');
        $user->setFirstname('Someone');
        $user->setEmail('test@aamv.net');

        $twig = m::mock(Environment::class);
        $twig->shouldReceive('render')->once()->with(
            'emails/registration.html.twig',
            ['user' => $user]
        )->andReturn('Test !!');

        $symfonyMailer = m::mock(MailerInterface::class);
        $symfonyMailer->shouldReceive('send')->once();

        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldNotReceive('error');

        $mailer = new RegistrationMailer($twig, $symfonyMailer);
        $mailer->setLogger($logger);
        $mailer->send($user);
    }
}
