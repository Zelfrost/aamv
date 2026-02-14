<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoadUserData extends Fixture implements OrderedFixtureInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setRoles([User::ROLE_ADMIN]);
        $admin->setActive(true);
        $admin->setName('Admin');
        $admin->setFirstname('Random');
        $admin->setEmail('admin@aamv.net');
        $admin->setPhoneNumber('0600000000');
        $admin->setCity('Nowhere');

        $assistante = new User();
        $assistante->setPassword($this->hasher->hashPassword($assistante, 'assistante'));
        $assistante->setRoles([User::ROLE_ASSISTANT, User::ROLE_MEMBER]);
        $assistante->setActive(true);
        $assistante->setName('Assistant');
        $assistante->setFirstname('Random');
        $assistante->setEmail('assistante@aamv.net');
        $assistante->setPhoneNumber('0600000000');
        $assistante->setCity('Lille');

        $notMember = new User();
        $notMember->setPassword($this->hasher->hashPassword($notMember, 'not-member'));
        $notMember->setRoles([User::ROLE_ASSISTANT]);
        $notMember->setActive(true);
        $notMember->setName('Not member');
        $notMember->setFirstname('Random');
        $notMember->setEmail('not-member@aamv.net');
        $notMember->setPhoneNumber('0600000000');
        $notMember->setCity('Lille');

        $parent = new User();
        $parent->setPassword($this->hasher->hashPassword($parent, 'parent'));
        $parent->setRoles([User::ROLE_PARENT]);
        $parent->setActive(true);
        $parent->setName('Parent');
        $parent->setFirstname('Random');
        $parent->setEmail('parent@aamv.net');
        $parent->setPhoneNumber('0600000000');
        $parent->setCity('Lille');

        $manager->persist($admin);
        $manager->persist($assistante);
        $manager->persist($notMember);
        $manager->persist($parent);

        $manager->flush();

        $this->addReference('admin', $admin);
        $this->addReference('assistante', $assistante);
        $this->addReference('not-member', $notMember);
        $this->addReference('parent', $parent);
    }

    public function getOrder(): int
    {
        return 1;
    }
}
