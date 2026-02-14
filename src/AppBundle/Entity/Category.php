<?php

namespace AppBundle\Entity;

use AppBundle\Service\Validator\Constraints;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'AppBundle\Repository\CategoryRepository')]
#[ORM\Table(name: 'category')]
class Category
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    private $name;

    #[ORM\Column(name: 'position', type: 'integer')]
    private $position;

    #[ORM\Column(name: 'type', type: 'string')]
    private $type;

    #[ORM\Column(name: 'for_members', type: 'boolean')]
    private $forMembers;

    #[ORM\Column(name: 'order_field', type: 'string')]
    #[Assert\Choice(choices: ['name', 'date'], message: 'Le tri ne peut se faire que par nom ou par date')]
    private $orderField;

    #[ORM\OneToMany(targetEntity: 'Tool', mappedBy: 'category', cascade: ['persist'])]
    private $tools;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function isForMembers()
    {
        return $this->forMembers;
    }

    public function setForMembers($forMembers)
    {
        $this->forMembers = $forMembers;

        return $this;
    }

    public function getTools()
    {
        return $this->tools;
    }

    public function setTools($tools)
    {
        $this->tools = $tools;

        return $this;
    }

    public function getOrderField()
    {
        return $this->orderField;
    }

    public function setOrderField($orderField)
    {
        $this->orderField = $orderField;

        return $this;
    }
}
