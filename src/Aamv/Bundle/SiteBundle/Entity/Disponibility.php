<?php

namespace Aamv\Bundle\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Disponibility
 *
 * @ORM\Table(name="disponibilities")
 * @ORM\Entity
 */
class Disponibility
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
     * @var User
     *
     * @ORM\Column(name="number_of_children", type="integer")
     */
    private $numberOfChildren;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_at", type="datetime")
     */
    private $startAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_at", type="datetime")
     */
    private $endAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Aamv\Bundle\SiteBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id")
     */
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
     * @return News
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
     * Set startAt
     *
     * @param \DateTime $startAt
     * @return News
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime 
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param \DateTime $endAt
     * @return News
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return \DateTime 
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set childminder
     *
     * @param Aamv\Bundle\SiteBundle\Entity\User $childminder
     * @return News
     */
    public function setChildminder($childminder)
    {
        $this->childminder = $childminder;

        return $this;
    }

    /**
     * Get childminder
     *
     * @return Aamv\Bundle\SiteBundle\Entity\User 
     */
    public function getChildminder()
    {
        return $this->childminder;
    }
}
