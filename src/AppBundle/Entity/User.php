<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends Person implements UserInterface, EncoderAwareInterface
{
    const ROLE_PARENT    = 'ROLE_PARENT';
    const ROLE_ASSISTANT = 'ROLE_ASSISTANT';
    const ROLE_MEMBER    = 'ROLE_MEMBER';
    const ROLE_TRAINEE   = 'ROLE_TRAINEE';
    const ROLE_ADMIN     = 'ROLE_ADMIN';

    /**
     * @Assert\Length(max="4096")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(name="legacy_password", type="string", length=64, nullable=true)
     */
    private $legacyPassword;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $active;

    /**
     * @var string
     */
    private $currentPassword;

    /**
     * @var \DateTime;
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="password_reinitialization_code", type="string", nullable=true)
     */
    private $passwordReinitializationCode;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ad", mappedBy="author")
     */
    private $ads;

    public function __construct()
    {
        $this->active = true;
        $this->createdAt = new \DateTime();
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        $this->legacyPassword = null;

        return $this;
    }

    public function getPassword()
    {
        if (null !== $this->legacyPassword) {
            return $this->legacyPassword;
        }

        return $this->password;
    }

    public function setLegacyPassword($legacyPassword)
    {
        $this->legacyPassword = $legacyPassword;

        return $this;
    }

    public function getLegacyPassword()
    {
        return $this->legacyPassword;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole($role)
    {
        $this->roles[] = $role;

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getEncoderName()
    {
        if ($this->isLegacy()) {
            return 'legacy';
        }

        return 'default';
    }

    public function isLegacy()
    {
        return $this->legacyPassword !== null ? true : false;
    }

    public function setCurrentPassword($currentPassword)
    {
        $this->currentPassword = $currentPassword;

        return $this;
    }

    public function getCurrentPassword()
    {
        return $this->currentPassword;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getPasswordReinitializationCode()
    {
        return $this->passwordReinitializationCode;
    }

    public function setPasswordReinitializationCode($passwordReinitializationCode)
    {
        $this->passwordReinitializationCode = $passwordReinitializationCode;

        return $this;
    }

    public function getOldAds()
    {
        $oldAds = [];

        foreach ($this->ads as $ad) {
            if ((new \DateTime())->sub(new \DateInterval('P1M')) > $ad->getCreatedAt()) {
                $oldAds[] = $ad;
            }
        }

        return $oldAds;
    }
}
