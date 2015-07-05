<?php

namespace Aamv\Bundle\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aamv\Bundle\SiteBundle\Entity\News;
use Aamv\Bundle\SiteBundle\Entity\User;
use Aamv\Bundle\SiteBundle\Entity\Ads;

class LoadDatas implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername("ddeconinck")
            ->setPlainPassword("12345")
            ->setName('Deconinck')
            ->setFirstname('Damien')
            ->setEmail("deconinck.damien@gmail.com")
            ->setEnabled(true)
            ->addRole('ROLE_ADMIN')
        ;
        $manager->persist($user);

        // News
        $news = new News();
        $news
            ->setTitle('Une news comme une autre - Numéro 1')
            ->setContent('Une news avec du texte, des infos, du blabla sur les nouveautés :)')
            ->setAuthor($user)
        ;
        $manager->persist($news);

        // Ads
        $ads = new Ads();
        $ads
            ->setTitle('Une annonce comme une autre - Numéro 1')
            ->setContent("Une annonce avec du texte, des infos, du blabla sur l'ass mat' :)")
            ->setAuthor($user)
        ;
        $manager->persist($ads);

        // Enregistrement en base
        $manager->flush();
    }
}
