<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'city')]
#[ORM\Entity(repositoryClass: 'AppBundle\Repository\CityRepository')]
class City
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(type: 'string', nullable: false)]
    private $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
