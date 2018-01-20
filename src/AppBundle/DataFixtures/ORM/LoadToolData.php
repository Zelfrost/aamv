<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Tool;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;

class LoadToolData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
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

        $fs->touch('web/public/tools/toolA.txt');
        $fs->touch('web/public/tools/toolB.txt');
        $fs->touch('web/public/tools/toolC.txt');
    }

    public function getOrder()
    {
        return 4;
    }
}
