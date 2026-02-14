<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Tool;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;

class LoadToolData extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $fs = new Filesystem();

        $toolA = new Tool();
        $toolA->setName('Document numéro 1');
        $toolA->setRealName('toolA.txt');
        $toolA->setUpdatedAt(new \DateTime());

        $toolB = new Tool();
        $toolB->setName('Un autre document');
        $toolB->setRealName('toolB.txt');
        $toolB->setUpdatedAt(new \DateTime());

        $toolC = new Tool();
        $toolC->setName('Le dernier document');
        $toolC->setRealName('toolC.txt');
        $toolC->setUpdatedAt(new \DateTime());

        $manager->persist($toolA);
        $manager->persist($toolB);
        $manager->persist($toolC);
        $manager->flush();

        $fs->touch('public/public/tools/toolA.txt');
        $fs->touch('public/public/tools/toolB.txt');
        $fs->touch('public/public/tools/toolC.txt');
    }

    public function getOrder(): int
    {
        return 4;
    }
}
