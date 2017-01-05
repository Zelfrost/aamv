<?php

namespace AppBundle\Service\Mailer;

use AppBundle\Entity\User;
use AppBundle\Service\Mailer\RegistrationMailer;
use \Mockery as m;

class RegistrationMailerTest extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $user = new User();
        $user->setName('Somename');
        $user->setFirstname('Someone');
        $user->setEmail('test@aamv.net');

        $twig = m::mock('Twig_Environment');
        $twig->shouldReceive('render')->once()->with(
            'emails/registration.html.twig',
            ['user' => $user]
        )->andReturn('Test !!');

        $swiftMailer = m::mock('Swift_Mailer');
        $swiftMailer->shouldReceive('send')->once()->with(\Mockery::on(function ($message) {
            if (
                $message->getFrom() !== ['registration@aamv.net' => 'AAMV']
                || $message->getTo() !== ['test@aamv.net' => null]
                || $message->getSubject() !== 'Bienvenue sur le site de l\'AAMV'
                || $message->getBody() !== 'Test !!'
            ) {
                return false;
            }

            return true;
        }));

        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldNotReceive('error');

        $mailer = new RegistrationMailer($twig, $swiftMailer);
        $mailer->setLogger($logger);
        $mailer->send($user);
    }
}
