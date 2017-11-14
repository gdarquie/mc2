<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Distributor
 *
 * @ORM\Table(name="distributor")
 * @ORM\Entity
 */
class Distributor
{

    /**
     * @var integer
     *
     * @ORM\Column(name="distributor_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $distributorId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Film", mappedBy="distributors")
     */
    private $filmsDistributors;

    /**
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $last_update;

    /**
     * @return int
     */
    public function getDistributorId()
    {
        return $this->distributorId;
    }

    /**
     * @param int $distributorId
     */
    public function setDistributorId($distributorId)
    {
        $this->distributorId = $distributorId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param mixed $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @param mixed $last_update
     */
    public function setLastUpdate($last_update)
    {
        $this->last_update = $last_update;
    }

    /**
     * @return mixed
     */
    public function getFilmsDistributors()
    {
        return $this->filmsDistributors;
    }

    /**
     * @param mixed $filmsDistributors
     */
    public function setFilmsDistributors($filmsDistributors)
    {
        $this->filmsDistributors = $filmsDistributors;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

}