<?php

namespace Aamv\Bundle\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aamv\Bundle\SiteBundle\Entity\News;

class LoadQuestionData implements FixtureInterface {

    public function load(ObjectManager $manager) {

        // News 1
        $news1 = new News();

        $news1
                ->setTitle('Une news comme une autre')
                ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
                ->setAuthor('Guillaume')
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());


        $manager->persist($news1);

        // News 2
        $news2 = new News();

        $news2
                ->setTitle('Une news comme une autre')
                ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
                ->setAuthor('Guillaume')
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());

        $manager->persist($news2);

        // News 3
        $news3 = new News();

        $news3
                ->setTitle('Une news comme une autre')
                ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
                ->setAuthor('Guillaume')
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());

        $manager->persist($news3);

        // News 4
        $news4 = new News();

        $news4
                ->setTitle('Une news comme une autre')
                ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
                ->setAuthor('Guillaume')
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());

        $manager->persist($news4);

        // News 5
        $news5 = new News();

        $news5
                ->setTitle('Une news comme une autre')
                ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
                ->setAuthor('Guillaume')
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());

        $manager->persist($news5);


        // Enregistrement en base
        $manager->flush();
    }

}
