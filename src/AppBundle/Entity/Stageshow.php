<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Stageshow
 *
 * @ORM\Table(name="stageshow")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StageshowRepository")
 */
class Stageshow
{

    /**
     * @var integer
     *
     * @ORM\Column(name="stageshow_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $stageshowId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=500, nullable=true)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="production", type="string", length=255, nullable=true)
     */
    private $production;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=500, nullable=true)
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="opening", type="date", nullable=true)
     */
    private $opening;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Film")
     * @ORM\JoinTable(name="stageshow_has_film",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stageshow_id", referencedColumnName="stageshow_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="film_id")
     *   }
     * )
     */
    private $films;

    /**
     * @var integer
     *
     * @ORM\Column(name="ibdb", type="integer", nullable=true)
     */
    private $ibdb;

    /**
     * @var string
     *
     * @ORM\Column(name="race", type="string", length=45, nullable=true)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closing", type="date", nullable=true)
     */
    private $closing;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer", nullable=true)
     */
    private $count;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Stagenumber", mappedBy="stageshow")
     *
     */
    private $stagenumbers;

    /**
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $last_update;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="stageshow_has_composer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stageshow_id", referencedColumnName="stageshow_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $composers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="stageshow_has_book",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stageshow_id", referencedColumnName="stageshow_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $books;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="stageshow_has_lyricist",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stageshow_id", referencedColumnName="stageshow_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $lyricists;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="stageshow_has_choreographer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stageshow_id", referencedColumnName="stageshow_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $choreographers;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="stageshow_has_director",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stageshow_id", referencedColumnName="stageshow_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $directors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="stageshow_has_design",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stageshow_id", referencedColumnName="stageshow_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $designs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="stageshow_has_editor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stageshow_id", referencedColumnName="stageshow_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="editors", referencedColumnName="id")
     *   }
     * )
     */
    private $editors;

    /**
     * @return int
     */
    public function getStageshowId()
    {
        return $this->stageshowId;
    }

    /**
     * @param int $stageshowId
     */
    public function setStageshowId($stageshowId)
    {
        $this->stageshowId = $stageshowId;
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
     * @return string
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * @param string $production
     */
    public function setProduction($production)
    {
        $this->production = $production;
    }

    /**
     * @return \DateTime
     */
    public function getOpening()
    {
        return $this->opening;
    }

    /**
     * @param \DateTime $opening
     */
    public function setOpening($opening)
    {
        $this->opening = $opening;
    }

    /**
     * @return mixed
     */
    public function getFilms()
    {
        return $this->films;
    }

    /**
     * @param mixed $films
     */
    public function setFilms($films)
    {
        $this->films = $films;
    }

    /**
     * @return int
     */
    public function getIbdb()
    {
        return $this->ibdb;
    }

    /**
     * @param int $ibdb
     */
    public function setIbdb($ibdb)
    {
        $this->ibdb = $ibdb;
    }

    /**
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param string $race
     */
    public function setRace($race)
    {
        $this->race = $race;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getClosing()
    {
        return $this->closing;
    }

    /**
     * @param \DateTime $closing
     */
    public function setClosing($closing)
    {
        $this->closing = $closing;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComposers()
    {
        return $this->composers;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $composers
     */
    public function setComposers($composers)
    {
        $this->composers = $composers;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $books
     */
    public function setBooks($books)
    {
        $this->books = $books;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLyricists()
    {
        return $this->lyricists;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $lyricists
     */
    public function setLyricists($lyricists)
    {
        $this->lyricists = $lyricists;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChoreographers()
    {
        return $this->choreographers;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $choreographers
     */
    public function setChoreographers($choreographers)
    {
        $this->choreographers = $choreographers;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDirectors()
    {
        return $this->directors;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $directors
     */
    public function setDirectors($directors)
    {
        $this->directors = $directors;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDesigns()
    {
        return $this->designs;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $designs
     */
    public function setDesigns($designs)
    {
        $this->designs = $designs;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getStagenumbers()
    {
        return $this->stagenumbers;
    }

    /**
     * @param mixed $stagenumbers
     */
    public function setStagenumbers($stagenumbers)
    {
        $this->stagenumbers = $stagenumbers;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEditors()
    {
        return $this->editors;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $editors
     */
    public function setEditors($editors)
    {
        $this->editors = $editors;
    }

    public function addEditors(User $user)
    {
        if ($this->editors->contains($user)) {
            return;
        }

        $this->editors[] = $user;
    }

    public function __toString()
    {
        return (string) $this->getTitle();
    }

}
