<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Disponibility;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadDisponibilityData extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $disponibilityA = new Disponibility();
        $disponibilityA->setNumberOfChildren(2);
        $disponibilityA->setPeriod('Décembre 2016');
        $disponibilityA->setChildminder($this->getReference('assistante', \AppBundle\Entity\User::class));

        $disponibilityB = new Disponibility();
        $disponibilityB->setNumberOfChildren(1);
        $disponibilityB->setPeriod('Mars 2017');
        $disponibilityB->setChildminder($this->getReference('assistante', \AppBundle\Entity\User::class));

        $manager->persist($disponibilityA);
        $manager->persist($disponibilityB);
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}
