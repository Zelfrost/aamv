<?php

namespace AppBundle\Entity;

use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\Mapping as ORM;

/**
 * EventPicture
 *
 * @ORM\Table(name="event_picture")
 * @ORM\Entity
 */
class EventPicture
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
     * @ORM\Column(name="real_name", type="text")
     */
    private $realName;

    /**
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventPictures")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @var UploadedFile
     */
    private $file;


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
     * Set realName
     *
     * @param string $realName
     * @return EventPicture
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;

        return $this;
    }

    /**
     * Get realName
     *
     * @return string
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * Set event
     *
     * @param Event $event
     *
     * @return EventPicture
     */
    public function setEvent(?Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->getFile()->move(
            __DIR__.'/../../../../../web/public/eventPictures/'.str_replace(' ', '', $this->event->getName()).'/',
            $this->file->getClientOriginalName()
        );

        $this->realName = $this->file->getClientOriginalName();

        $this->setFile(null);
    }

    public function remove()
    {
        if (null === $this->realName) {
            return;
        }

        $path = __DIR__.'/../../../../../web/public/eventPictures/'.str_replace(' ', '', $this->event->getName()).'/'.$this->realName;
        $fs = new Filesystem();

        if ($fs->exists($path)) {
            $fs->remove($path);
        }
    }
}
