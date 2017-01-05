<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($encoder->encodePassword($admin, 'admin'));
        $admin->setRoles([User::ROLE_ADMIN]);
        $admin->setActive(true);
        $admin->setName('Admin');
        $admin->setFirstname('Super');
        $admin->setEmail('admin.super@itsalie.com');
        $admin->setPhoneNumber('0600000000');
        $admin->setCity('Nowhere');

        $assistante = new User();
        $assistante->setUsername('assistante');
        $assistante->setPassword($encoder->encodePassword($assistante, 'assistante'));
        $assistante->setRoles([User::ROLE_ASSISTANTE]);
        $assistante->setActive(true);
        $assistante->setName('Deconinck');
        $assistante->setFirstname('Damien');
        $assistante->setEmail('deconinck.damien@gmail.com');
        $assistante->setPhoneNumber('0600000000');
        $assistante->setCity('Lille');

        $parent = new User();
        $parent->setUsername('parent');
        $parent->setPassword($encoder->encodePassword($parent, 'parent'));
        $parent->setRoles([User::ROLE_PARENT]);
        $parent->setActive(true);
        $parent->setName('Ratour');
        $parent->setFirstname('Simon');
        $parent->setEmail('ratour.simon@itsalie.com');
        $parent->setPhoneNumber('0000000000');
        $parent->setCity('Lille');

        $manager->persist($admin);
        $manager->persist($assistante);
        $manager->persist($parent);

        $manager->flush();

        $this->addReference('admin', $admin);
        $this->addReference('assistante', $assistante);
        $this->addReference('parent', $parent);
    }

    public function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
