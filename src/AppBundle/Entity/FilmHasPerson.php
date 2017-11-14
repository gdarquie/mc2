<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FilmHasPerson
 *
 * @ORM\Table(name="film_has_person", indexes={@ORM\Index(name="fk_film_has_person_person1_idx", columns={"person_id"}), @ORM\Index(name="fk_film_has_person_film1_idx", columns={"film_id"}), @ORM\Index(name="fk_film_has_person_profession1_idx", columns={"profession_id"})})
 * @ORM\Entity
 */
class FilmHasPerson
{
    /**
     * @var integer
     *
     * @ORM\Column(name="profession_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $professionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="person_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $personId;

    /**
     * @var integer
     *
     * @ORM\Column(name="film_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $filmId;



    /**
     * Set professionId
     *
     * @param integer $professionId
     *
     * @return FilmHasPerson
     */
    public function setProfessionId($professionId)
    {
        $this->professionId = $professionId;

        return $this;
    }

    /**
     * Get professionId
     *
     * @return integer
     */
    public function getProfessionId()
    {
        return $this->professionId;
    }

    /**
     * Set personId
     *
     * @param integer $personId
     *
     * @return FilmHasPerson
     */
    public function setPersonId($personId)
    {
        $this->personId = $personId;

        return $this;
    }

    /**
     * Get personId
     *
     * @return integer
     */
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * Set filmId
     *
     * @param integer $filmId
     *
     * @return FilmHasPerson
     */
    public function setFilmId($filmId)
    {
        $this->filmId = $filmId;

        return $this;
    }

    /**
     * Get filmId
     *
     * @return integer
     */
    public function getFilmId()
    {
        return $this->filmId;
    }
}
