<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Studio
 *
 * @ORM\Table(name="studio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudioRepository")
 */
class Studio
{

    /**
     * @var integer
     *
     * @ORM\Column(name="studio_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $studioId;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Film", mappedBy="studios")
     */
    private $filmsStudios;

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
    public function getStudioId()
    {
        return $this->studioId;
    }

    /**
     * @param int $studioId
     */
    public function setStudioId($studioId)
    {
        $this->studioId = $studioId;
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

    public function __toString()
    {
        return $this->getTitle();
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
    public function getFilmsStudios()
    {
        return $this->filmsStudios;
    }

    /**
     * @param mixed $filmsStudios
     */
    public function setFilmsStudios($filmsStudios)
    {
        $this->filmsStudios = $filmsStudios;
    }




}
