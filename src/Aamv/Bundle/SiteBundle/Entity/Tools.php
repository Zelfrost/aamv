<?php

namespace Aamv\Bundle\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tools
 *
 * @ORM\Table(name="tools")
 * @ORM\Entity(repositoryClass="Aamv\Bundle\SiteBundle\Repository\ToolsRepository")
 */
class Tools
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
     * @var string
     *
     * @ORM\Column(name="real_name", type="string", length=255)
     */
    private $realName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="from_aamv", type="boolean")
     */
    private $fromAamv;

    /**
     * @var Datetime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var UploadedFile
     */
    private $file;

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

    public function getRealName()
    {
        return $this->realName;
    }

    public function setRealName($realName)
    {
        $this->realName = $realName;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\Datetime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isFromAamv()
    {
        return $this->fromAamv;
    }

    public function setFromAamv($fromAamv)
    {
        $this->fromAamv = $fromAamv;

        return $this;
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
            __DIR__.'/../../../../../web/public/tools/'. ($this->isFromAamv()?'aamv':'veronalice').'/',
            $this->getFile()->getClientOriginalName()
        );

        $this->realName = $this->getFile()->getClientOriginalName();

        $this->setFile(null);
    }

    public function refreshUpdated() {
        $this->setUpdatedAt(new \DateTime("now"));
    }
}
