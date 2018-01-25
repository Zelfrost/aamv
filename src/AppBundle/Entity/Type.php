<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeRepository")
 * @ORM\Table(name="type")
 */
class Type
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer", nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="for_members", type="boolean")
     */
    private $forMembers;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Tool",
     *      mappedBy="type",
     *      cascade={"persist"}
     * )
     */
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

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;

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
}
