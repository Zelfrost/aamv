<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\News;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadNewsData extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $newsA = new News();
        $newsA->setTitle('Nous avons de grandes nouvelles !');
        $newsA->setContent('
            <p>Tout plein de bonnes nouvelles à vous annoncer :</p>
            <ul>
                <li>Des nouvelles <b>fonctionnalités</b></li>
                <li>Un <b>design</b> tout neuf</li>
                <li>Une utilisation <b>plus simple</b> du site</li>
            </ul>
        ');
        $newsA->setAuthor($this->getReference('admin', \AppBundle\Entity\User::class));
        $newsA->setImportant(false);
        $newsA->setCreatedAt(new \DateTime());
        $newsA->setUpdatedAt(new \DateTime());

        $newsB = new News();
        $newsB->setTitle('Nouvelle réunion de l\'association');
        $newsB->setContent('
            <p>Notre prochaine réunion aura lieu le <strong>Mercredi 25 Janvier</strong> 2017 de <em>19h à 21h30</em>
            à la <strong>salle Marianne</strong>, place de la République à Villeneuve d\'Ascq.</p>
            <p>Assistantes maternelles et parents y sont conviés si ils sont en recherche d\'un mode de garde.</p>
            <p>Si vous vous garez sur le parking de Carrefour Market, celui-ci ferme à 20h30.</p>
        ');
        $newsB->setAuthor($this->getReference('admin', \AppBundle\Entity\User::class));
        $newsB->setImportant(false);
        $newsB->setCreatedAt(new \DateTime());
        $newsB->setUpdatedAt(new \DateTime());

        $manager->persist($newsA);
        $manager->persist($newsB);
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 5;
    }
}
