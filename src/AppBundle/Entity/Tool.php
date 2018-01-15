<?php

namespace AppBundle\Entity;

use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tool
 *
 * @ORM\Table(name="tool")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ToolRepository")
 */
class Tool
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
     * @var Type
     *
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="tools")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     */
    private $type;

    /**
     * @var Datetime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

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

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->createdAt = $createdAt;

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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

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

        $file = $this->getFile();
        $filename = substr(basename($file->getClientOriginalName(), $file->guessExtension()), 0, -1);
        $filename = $filename.'-'.date('YmdHis').'.'.$file->guessExtension();

        $this->getFile()->move(
            __DIR__.'/../../../web/public/tools/'. ($this->isFromAamv()?'aamv':'veronalice').'/',
            $filename
        );

        $this->realName = $filename;

        $this->setFile(null);
    }

    public function remove()
    {
        if (null === $this->getRealName()) {
            return;
        }

        $basePath = __DIR__.'/../../../web/public/tools/';
        $path = $basePath.($this->isFromAamv()?'aamv':'veronalice').'/'.$this->getRealName();
        $fs = new Filesystem();

        if ($fs->exists($path)) {
            $fs->remove($path);
        }
    }
}
