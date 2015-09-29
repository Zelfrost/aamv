<?php

namespace Aamv\Bundle\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Aamv\Bundle\SiteBundle\Validator\Constraints;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Aamv\Bundle\SiteBundle\Repository\UserRepository")
 * @Constraints\CityFromApi
 */
class User extends BaseUser
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
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(name="neighborhood", type="string", length=255, nullable = true)
     */
    private $neighborhood;

    /**
     * @ORM\Column(name="phone_number", type="string", length=10)
     */
    private $phoneNumber;

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

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function addRole($role)
    {
        $this->roles[] = $role;

        return $this;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getBaseRole()
    {
        if (in_array('ROLE_PARENT', $this->roles)) {
            return 'parent';
        }

        return 'assistante';
    }

    public function setBaseRole($baseRole)
    {
        if ($baseRole == 'parent') {
            $this->roles[] = 'ROLE_PARENT';
        } else {
            $this->roles[] = 'ROLE_ASSISTANTE';
        }
    }

    public function getFullname()
    {
        return $this->firstname . " " . $this->name;
    }
}
