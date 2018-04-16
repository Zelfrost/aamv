<?php

namespace AppBundle\Entity;

use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tool
 *
 * @ORM\Table(name="tool")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ToolRepository")
 */
class Tool
{
    const PATH = '/public/tools';

    const DOC_TYPE = 'doc';
    const TOOL_TYPE = 'tool';

    const JOIN_NAME = 'admin-join-tool';
    const DISPONIBILITIES_NAME = 'admin-disponibilities-tool';

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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="tools")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     * @Assert\Choice(choices={"doc", "tool"})
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

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

    public function getFullname()
    {
        if (null !== $this->date) {
            return sprintf('%s - %s', $this->name, $this->date->format('d/m/Y'));
        }

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

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;

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

    /**
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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

    public function getPath()
    {
        return sprintf(
            '%s/%s/%s',
            Tool::PATH,
            null !== $this->category && $this->category->isForMembers() ? 'members' : null,
            $this->realName
        );
    }

    public function getFullPath()
    {
        return sprintf(
            '%s/%s',
            __DIR__ . '/../../../web' . self::PATH,
            null !== $this->category && $this->category->isForMembers() ? 'members' : null
        );
    }

    public function getFullyQualifiedPath()
    {
        return sprintf(
            '%s/%s',
            $this->getFullPath(),
            $this->realName
        );
    }

    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $file = $this->getFile();
        $filename = substr(basename($file->getClientOriginalName(), $file->guessExtension()), 0, -1);
        $filename = $filename.'-'.date('YmdHis').'.'.$file->guessExtension();

        $this->realName = $filename;

        $this->getFile()->move($this->getFullPath(), $this->realName);

        $this->setFile(null);
    }

    public function remove()
    {
        if (null === $this->getRealName()) {
            return;
        }

        $fs = new Filesystem();

        if ($fs->exists($this->getFullyQualifiedPath())) {
            $fs->remove($this->getFullyQualifiedPath());
        }
    }
}
