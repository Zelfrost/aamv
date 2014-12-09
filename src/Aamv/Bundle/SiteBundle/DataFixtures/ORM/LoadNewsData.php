<?php

namespace Aamv\Bundle\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aamv\Bundle\SiteBundle\Entity\News;

class LoadQuestionData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // News 1
        $news1 = new News();

        $news1
            ->setTitle('Une news comme une autre - Numéro 1')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news1);


        // News 2
        $news2 = new News();

        $news2
            ->setTitle('Une news comme une autre - Numéro 2')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news2);


        // News 3
        $news3 = new News();

        $news3
            ->setTitle('Une news comme une autre - Numéro 3')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news3);


        // News 4
        $news4 = new News();

        $news4
            ->setTitle('Une news comme une autre - Numéro 4')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news4);


        // News 5
        $news5 = new News();

        $news5
            ->setTitle('Une news comme une autre - Numéro 5')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news5);


        // News 6
        $news6 = new News();

        $news6
            ->setTitle('Une news comme une autre - Numéro 6')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news6);


        // News 7
        $news7 = new News();

        $news7
            ->setTitle('Une news comme une autre - Numéro 7')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news7);


        // News 8
        $news8 = new News();

        $news8
            ->setTitle('Une news comme une autre - Numéro 8')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news8);


        // News 9
        $news9 = new News();

        $news9
            ->setTitle('Une news comme une autre - Numéro 9')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news9);


        // News 10
        $news10 = new News();

        $news10
            ->setTitle('Une news comme une autre - Numéro 10')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news10);


        // News 11
        $news11 = new News();

        $news11
            ->setTitle('Une news comme une autre - Numéro 11')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news11);


        // News 12
        $news12 = new News();

        $news12
            ->setTitle('Une news comme une autre - Numéro 12')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news12);


        // News 13
        $news13 = new News();

        $news13
            ->setTitle('Une news comme une autre - Numéro 13')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news13);


        // News 14
        $news14 = new News();

        $news14
            ->setTitle('Une news comme une autre - Numéro 14')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news14);


        // News 15
        $news15 = new News();

        $news15
            ->setTitle('Une news comme une autre - Numéro 15')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor('Guillaume')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news15);


        // Enregistrement en base
        $manager->flush();
    }
}
