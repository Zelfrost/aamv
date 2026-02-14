<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'disponibility')]
#[ORM\Entity(repositoryClass: 'AppBundle\Repository\DisponibilityRepository')]
class Disponibility
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(name: 'number_of_children', type: 'integer')]
    private $numberOfChildren;

    #[ORM\Column(name: 'period', type: 'string', length: 500)]
    private $period;

    #[ORM\ManyToOne(targetEntity: 'Person', inversedBy: 'disponibilities')]
    #[ORM\JoinColumn(nullable: true, referencedColumnName: 'id')]
    private $childminder;

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
     * Set numberOfChildren
     *
     * @param int $numberOfChildren
     * @return $this
     */
    public function setNumberOfChildren($numberOfChildren)
    {
        $this->numberOfChildren = $numberOfChildren;

        return $this;
    }

    /**
     * Get numberOfChildren
     *
     * @return int
     */
    public function getNumberOfChildren()
    {
        return $this->numberOfChildren;
    }

    /**
     * Set period
     *
     * @param string $period
     * @return $this
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param Person|null $childminder
     * @return $this
     */
    public function setChildminder($childminder)
    {
        $this->childminder = $childminder;

        return $this;
    }

    /**
     * Get childminder
     *
     * @return Person|null
     */
    public function getChildminder()
    {
        return $this->childminder;
    }
}
