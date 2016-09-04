<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event
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
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=1000)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var ArrayCollection EventPicture
     *
     * @ORM\OneToMany(
     *      targetEntity="EventPicture",
     *      mappedBy="event",
     *      cascade={"persist", "remove"},
     *      orphanRemoval=true
     * )
     */
    private $eventPictures;

    /**
     * @var UploadedFile
     */
    private $file;

    public function __construct()
    {
        $this->eventPictures = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add a picture
     *
     * @param EventPicture $eventPicture
     *
     * @return Event
     */
    public function addEventPicture(EventPicture $eventPicture)
    {
        $eventPicture->setEvent($this);

        $this->eventPictures[] = $eventPicture;

        return $this;
    }

    /**
     * Remove a picture
     *
     * @param EventPicture $eventPicture
     *
     * @return Event
     */
    public function removeEventPicture(EventPicture $eventPicture)
    {
        $this->eventPictures->removeElement($eventPicture);

        return $this;
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventPictures()
    {
        return $this->eventPictures;
    }

    public function __toString()
    {
        return $this->name;
    }
}
