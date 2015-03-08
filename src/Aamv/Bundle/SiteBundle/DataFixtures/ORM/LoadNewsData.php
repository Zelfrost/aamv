<?php

namespace Aamv\Bundle\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aamv\Bundle\SiteBundle\Entity\News;
use Aamv\Bundle\UserBundle\Entity\User;

class LoadQuestionData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername("damdec")
            ->setPlainPassword("damdec")
            ->setEmail("deconinck.damien@gmail.com")
            ->setEnabled(true);
        $manager->persist($user);

        // News 1
        $news1 = new News(
            'Une news comme une autre - Numéro 1',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news1
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news1);


        // News 2
        $news2 = new News(
            'Une news comme une autre - Numéro 2',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news2
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news2);


        // News 3
        $news3 = new News(
            'Une news comme une autre - Numéro 3',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news3
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news3);


        // News 4
        $news4 = new News(
            'Une news comme une autre - Numéro 4',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news4
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news4);


        // News 5
        $news5 = new News(
            'Une news comme une autre - Numéro 5',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news5
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news5);


        // News 6
        $news6 = new News(
            'Une news comme une autre - Numéro 6',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news6
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news6);


        // News 7
        $news7 = new News(
            'Une news comme une autre - Numéro 7',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news7
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news7);


        // News 8
        $news8 = new News(
            'Une news comme une autre - Numéro 8',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news8
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news8);


        // News 9
        $news9 = new News(
            'Une news comme une autre - Numéro 9',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news9
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news9);


        // News 10
        $news10 = new News(
            'Une news comme une autre - Numéro 10',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news10
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news10);


        // News 11
        $news11 = new News(
            'Une news comme une autre - Numéro 11',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news11
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news11);


        // News 12
        $news12 = new News(
            'Une news comme une autre - Numéro 12',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news12
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news12);


        // News 13
        $news13 = new News(
            'Une news comme une autre - Numéro 13',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news13
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news13);


        // News 14
        $news14 = new News(
            'Une news comme une autre - Numéro 14',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news14
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news14);


        // News 15
        $news15 = new News(
            'Une news comme une autre - Numéro 15',
            'Une news avec du texte, des infos, du blabla sur les nouveautés :)'
        );
        $news15
            ->setAuthor($user)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($news15);


        // Enregistrement en base
        $manager->flush();
    }
}
