<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Disponibility;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDisponibilityData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $disponibilityA = new Disponibility();
        $disponibilityA->setNumberOfChildren(2);
        $disponibilityA->setPeriod('Décembre 2016');
        $disponibilityA->setChildminder($this->getReference('assistante'));

        $disponibilityB = new Disponibility();
        $disponibilityB->setNumberOfChildren(1);
        $disponibilityB->setPeriod('Mars 2017');
        $disponibilityB->setChildminder($this->getReference('assistante'));

        $manager->persist($disponibilityA);
        $manager->persist($disponibilityB);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
