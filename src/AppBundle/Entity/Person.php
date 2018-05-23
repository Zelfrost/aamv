<?php

namespace AppBundle\Entity;

use AppBundle\Service\Validator\Constraints;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"person" = "Person", "user" = "User"})
 * @Constraints\CityFromApiConstraint
 * @Assert\UniqueEntity(fields={"email"}, message="Cette adresse email est déjà utilisée.")
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Constraints\EmailConstraint
     */
    private $email;

    /**
     * @ORM\Column(name="phone_number", type="string", length=10, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(name="neighborhood", type="string", length=255, nullable = true)
     */
    private $neighborhood;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Disponibility", mappedBy="childminder")
     */
    private $disponibilities;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setNeighborhood($neighborhood)
    {
        $this->neighborhood = $neighborhood;

        return $this;
    }

    public function getNeighborhood()
    {
        return $this->neighborhood;
    }

    public function getFullname()
    {
        return sprintf('%s %s',
            $this->name,
            $this->firstname
        );
    }

    public function getDisponibilities()
    {
        return $this->disponibilities;
    }
}
