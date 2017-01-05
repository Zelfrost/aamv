<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Ad;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAdData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $adA = new Ad();
        $adA->setTitle('Plein de places !');
        $adA->setContent('
            <p>Deux nouvelles places se libèrent chez moi. Je peux à présent garder <b>deux</b> nouveaux bambins.</p>
            <p>Envoyez moi un mail si vous êtes intéressé(e) !</p>
        ');
        $adA->setDisponibilityDate(new \DateTime());
        $adA->setWishedDays(array(
            "Lundi",
            "Mardi",
            "Jeudi",
            "Vendredi",
        ));
        $adA->setType('day');
        $adA->setViewCount(12);
        $adA->setCreatedAt(new \DateTime());
        $adA->setUpdatedAt(new \DateTime());
        $adA->setAuthor($this->getReference('assistante'));

        $adB = new Ad();
        $adB->setTitle('Une place en Mars');
        $adB->setContent('
            <p>Un des enfants que je garde part à l\'école à partir de fin Février.</p>
            <p>Une place se libérera donc, et je cherche un nouvel enfant à garder :)</p>
            <p>Contactez moi si vous cherchez une assistante !</p>
        ');
        $adB->setDisponibilityDate(new \DateTime());
        $adB->setWishedDays(array(
            "Lundi",
            "Mardi",
            "Vendredi",
        ));
        $adB->setType('day');
        $adB->setViewCount(36);
        $adB->setCreatedAt(new \DateTime());
        $adB->setUpdatedAt(new \DateTime());
        $adB->setAuthor($this->getReference('assistante'));

        $manager->persist($adA);
        $manager->persist($adB);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
