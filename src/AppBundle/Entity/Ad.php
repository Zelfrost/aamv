<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ad')]
#[ORM\Entity(repositoryClass: 'AppBundle\Repository\AdRepository')]
class Ad
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(name: 'title', type: 'string', length: 255)]
    private $title;

    #[ORM\Column(name: 'content', type: 'text')]
    private $content;

    #[ORM\ManyToOne(targetEntity: 'User', inversedBy: 'ads')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'id')]
    private $author;

    #[ORM\Column(name: 'disponibility_date', type: 'datetime', nullable: true)]
    private $disponibilityDate;

    #[ORM\Column(name: 'wished_days', type: 'array', nullable: true)]
    private $wishedDays;

    #[ORM\Column(name: 'type', type: 'string', nullable: true)]
    private $type;

    #[ORM\Column(name: 'show_phone_number', type: 'boolean')]
    private $showPhoneNumber = false;

    #[ORM\Column(name: 'show_email', type: 'boolean')]
    private $showEmail = false;

    #[ORM\Column(name: 'view_count', type: 'integer')]
    private $viewCount = 0;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: true)]
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Ad
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Ad
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set author
     *
     * @param User $author
     * @return Ad
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set disponibilityDate
     *
     * @param \DateTime $disponibilityDate
     * @return Ad
     */
    public function setDisponibilityDate($disponibilityDate)
    {
        $this->disponibilityDate = $disponibilityDate;

        return $this;
    }

    /**
     * Get disponibilityDate
     *
     * @return \DateTime
     */
    public function getDisponibilityDate()
    {
        return $this->disponibilityDate;
    }

    /**
     * Set wishedDays
     *
     * @param array $wishedDays
     * @return Ad
     */
    public function setWishedDays($wishedDays)
    {
        $this->wishedDays = $wishedDays;

        return $this;
    }

    /**
     * Get wishedDays
     *
     * @return array
     */
    public function getWishedDays()
    {
        return $this->wishedDays;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Ad
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function showPhoneNumber(): bool
    {
        return $this->showPhoneNumber;
    }

    public function setShowPhoneNumber(bool $showPhoneNumber)
    {
        $this->showPhoneNumber = $showPhoneNumber;
    }

    public function showEmail(): bool
    {
        return $this->showEmail;
    }

    public function setShowEmail(bool $showEmail)
    {
        $this->showEmail = $showEmail;
    }

    /**
     * Increment view count
     *
     * @param integer $inc
     * @return Ad
     */
    public function addView($inc = 1)
    {
        $this->viewCount += $inc;

        return $this;
    }

    /**
     * Set viewCount
     *
     * @param integer $viewCount
     * @return Ad
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    /**
     * Get viewCount
     *
     * @return integer
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Ad
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Ad
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
