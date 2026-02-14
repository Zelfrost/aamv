<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherAwareInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'user')]
#[ORM\Entity(repositoryClass: 'AppBundle\Repository\UserRepository')]
class User extends Person implements UserInterface, PasswordAuthenticatedUserInterface, PasswordHasherAwareInterface
{
    const ROLE_PARENT    = 'ROLE_PARENT';
    const ROLE_ASSISTANT = 'ROLE_ASSISTANT';
    const ROLE_MEMBER    = 'ROLE_MEMBER';
    const ROLE_TRAINEE   = 'ROLE_TRAINEE';
    const ROLE_ADMIN     = 'ROLE_ADMIN';

    #[Assert\Length(max: 4096)]
    private $plainPassword;

    #[ORM\Column(type: 'string', length: 64)]
    private $password;

    #[ORM\Column(name: 'legacy_password', type: 'string', length: 64, nullable: true)]
    private $legacyPassword;

    #[ORM\Column(type: 'array')]
    private $roles;

    #[ORM\Column(name: 'is_active', type: 'boolean')]
    private $active;

    private $currentPassword;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private $createdAt;

    #[ORM\Column(name: 'password_reinitialization_code', type: 'string', nullable: true)]
    private $passwordReinitializationCode;

    #[ORM\Column(name: 'password_reinitialization_code_expires_at', type: 'datetime', nullable: true)]
    private $passwordReinitializationCodeExpiresAt;

    #[ORM\Column(name: 'consented_at', type: 'datetime', nullable: true)]
    private $consentedAt;

    #[ORM\OneToMany(targetEntity: 'AppBundle\Entity\Ad', mappedBy: 'author')]
    private $ads;

    public function __construct()
    {
        $this->active = true;
        $this->createdAt = new \DateTime();
    }

    public function getUserIdentifier(): string
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

    public function setPassword($password): static
    {
        $this->password = $password;
        $this->legacyPassword = null;

        return $this;
    }

    public function getPassword(): ?string
    {
        if (null !== $this->legacyPassword) {
            return $this->legacyPassword;
        }

        return $this->password;
    }

    public function setLegacyPassword($legacyPassword): static
    {
        $this->legacyPassword = $legacyPassword;

        return $this;
    }

    public function getLegacyPassword()
    {
        return $this->legacyPassword;
    }

    public function eraseCredentials(): void
    {
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole($role): static
    {
        $this->roles[] = $role;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPasswordHasherName(): ?string
    {
        return $this->isLegacy() ? 'legacy' : null;
    }

    public function isLegacy()
    {
        return $this->legacyPassword !== null ? true : false;
    }

    public function setCurrentPassword($currentPassword): static
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

    public function setActive($active): static
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

    public function setPasswordReinitializationCode($passwordReinitializationCode): static
    {
        $this->passwordReinitializationCode = $passwordReinitializationCode;

        return $this;
    }

    public function getPasswordReinitializationCodeExpiresAt()
    {
        return $this->passwordReinitializationCodeExpiresAt;
    }

    public function setPasswordReinitializationCodeExpiresAt($passwordReinitializationCodeExpiresAt): static
    {
        $this->passwordReinitializationCodeExpiresAt = $passwordReinitializationCodeExpiresAt;

        return $this;
    }

    public function isPasswordReinitializationCodeExpired()
    {
        if ($this->passwordReinitializationCodeExpiresAt === null) {
            return true;
        }

        return new \DateTime() > $this->passwordReinitializationCodeExpiresAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getConsentedAt()
    {
        return $this->consentedAt;
    }

    /**
     * @param \DateTime|null $consentedAt
     * @return $this
     */
    public function setConsentedAt($consentedAt)
    {
        $this->consentedAt = $consentedAt;

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
