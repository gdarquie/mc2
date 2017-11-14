<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Film
 *
 * @ORM\Table(name="film")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FilmRepository")
 */
class Film
{

    /**
     * @var integer
     *
     * @ORM\Column(name="film_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $filmId;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="productionyear", type="integer", nullable=true)
     */
    private $productionyear;

    /**
     * @var integer
     *
     * @ORM\Column(name="released", type="integer", nullable=true)
     */
    private $released;

    /**
     * @var string
     *
     * @ORM\Column(name="id_imdb", type="string", length=255, nullable=true)
     */
    private $idImdb;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Distributor")
     * @ORM\JoinTable(name="film_has_distributor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="film_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="distributor_id", referencedColumnName="distributor_id")
     *   }
     * )
     */
    private $distributors;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stageshow")
     * @ORM\JoinTable(name="film_has_stageshow",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="film_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="stageshow_id", referencedColumnName="stageshow_id")
     *   }
     * )
     */
    private $stageshows;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="ratio", type="string", length=255, nullable=true)
     */
    private $ratio;

    /**
     * @var integer
     *
     * @ORM\Column(name="length", type="integer", nullable=true)
     */
    private $length;

    /**
     * @var string
     *
     * @ORM\Column(name="contract", type="string", length=255, nullable=true)
     */
    private $contract;

    /**
     * @var integer
     *
     * @ORM\Column(name="rights", type="integer", nullable=true)
     */
    private $rights;

    /**
     * @var integer
     *
     * @ORM\Column(name="negative", type="integer", nullable=true)
     */
    private $negative;

    /**
     * @var integer
     *
     * @ORM\Column(name="pna", type="integer", nullable=true)
     */
    private $pna;

    /**
     * @var integer
     *
     * @ORM\Column(name="us_rentals", type="integer", nullable=true)
     */
    private $usRentals;

    /**
     * @var integer
     *
     * @ORM\Column(name="foreign_rentals", type="integer", nullable=true)
     */
    private $foreignRentals;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_rentals", type="integer", nullable=true)
     */
    private $totalRentals;

    /**
     * @var integer
     *
     * @ORM\Column(name="us_boxoffice", type="integer", nullable=true)
     */
    private $usBoxoffice;

    /**
     * @var integer
     *
     * @ORM\Column(name="foreign_boxoffice", type="integer", nullable=true)
     */
    private $foreignBoxoffice;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_boxoffice", type="integer", nullable=true)
     */
    private $totalBoxoffice;

    /**
     * @var string
     *
     * @ORM\Column(name="source_eco", type="text", length=65535, nullable=true)
     */
    private $sourceEco;

    /**
     * @var string
     *
     * @ORM\Column(name="archives", type="text", length=16777215, nullable=true)
     */
    private $archives;

    /**
     * @var string
     *
     * @ORM\Column(name="deleted", type="text", length=16777215, nullable=true)
     */
    private $deleted;


    /**
     * @var \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adapatation", referencedColumnName="thesaurus_id")
     * })
     */
    private $adaptation;

    /**
     * @var string
     *
     * @ORM\Column(name="remake", type="boolean", nullable=true)
     */
    private $remake;

    /**
     * @var string
     *
     * @ORM\Column(name="verdict", type="string", length=255, nullable=true)
     */
    private $verdict;

    /**
     * @var string
     *
     * @ORM\Column(name="pca_texte", type="text", length=16777215, nullable=true)
     */
    private $pcaTexte;

    /**
     * @var string
     *
     * @ORM\Column(name="legion", type="string", length=5, nullable=true)
     */
    private $legion;

    /**
     * @var string
     *
     * @ORM\Column(name="protestant", type="string", length=255, nullable=true)
     */
    private $protestant;

    /**
     * @var string
     *
     * @ORM\Column(name="harrisson", type="string", length=255, nullable=true)
     */
    private $harrisson;

    /**
     * @var string
     *
     * @ORM\Column(name="bord", type="string", length=255, nullable=true)
     */
    private $bord;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\State", inversedBy="film")
     * @ORM\JoinTable(name="film_has_state",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="film_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="state_id", referencedColumnName="state_id")
     *   }
     * )
     */
    private $state;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Censorship", inversedBy="film")
     * @ORM\JoinTable(name="film_has_censorship",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="film_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="censorship_id", referencedColumnName="censorship_id")
     *   }
     * )
     */
    private $censorship;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="film_has_director",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="film_id")
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
     * @ORM\JoinTable(name="film_has_producer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="film_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $producers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isComplete = false;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Studio")
     * @ORM\JoinTable(name="film_has_studio",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="film_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="studio_id", referencedColumnName="studio_id")
     *   }
     * )
     */

    private $studios;

    /**
     * @ORM\OneToMany(targetEntity="Number", mappedBy="film")
     */
    private $numbers;

    /**
     * @var string
     *
     * @ORM\Column(name="sample", type="boolean")
     */
    private $sample;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="film_has_editor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="film_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="editors", referencedColumnName="id")
     *   }
     * )
     */
    private $editors;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->state = new \Doctrine\Common\Collections\ArrayCollection();
        $this->censorship = new \Doctrine\Common\Collections\ArrayCollection();
        $this->numbers = new ArrayCollection();
        $this->distributors = new ArrayCollection();
        $this->editors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date_creation = new \DateTime();
        $this->last_update = new \DateTime();
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Film
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set productionyear
     *
     * @param integer $productionyear
     *
     * @return Film
     */
    public function setProductionyear($productionyear)
    {
        $this->productionyear = $productionyear;

        return $this;
    }

    /**
     * Get productionyear
     *
     * @return integer
     */
    public function getProductionyear()
    {
        return $this->productionyear;
    }

    /**
     * Set released
     *
     * @param integer $released
     *
     * @return Film
     */
    public function setReleased($released)
    {
        $this->released = $released;

        return $this;
    }

    /**
     * Get released
     *
     * @return integer
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * Set idImdb
     *
     * @param string $idImdb
     *
     * @return Film
     */
    public function setIdImdb($idImdb)
    {
        $this->idImdb = $idImdb;

        return $this;
    }

    /**
     * Get idImdb
     *
     * @return string
     */
    public function getIdImdb()
    {
        return $this->idImdb;
    }


    /**
     * Set color
     *
     * @param string $color
     *
     * @return Film
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set ratio
     *
     * @param string $ratio
     *
     * @return Film
     */
    public function setRatio($ratio)
    {
        $this->ratio = $ratio;

        return $this;
    }

    /**
     * Get ratio
     *
     * @return string
     */
    public function getRatio()
    {
        return $this->ratio;
    }

    /**
     * Set length
     *
     * @param integer $length
     *
     * @return Film
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return integer
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set contract
     *
     * @param string $contract
     *
     * @return Film
     */
    public function setContract($contract)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return string
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Set rights
     *
     * @param integer $rights
     *
     * @return Film
     */
    public function setRights($rights)
    {
        $this->rights = $rights;

        return $this;
    }

    /**
     * Get rights
     *
     * @return integer
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * Set negative
     *
     * @param integer $negative
     *
     * @return Film
     */
    public function setNegative($negative)
    {
        $this->negative = $negative;

        return $this;
    }

    /**
     * Get negative
     *
     * @return integer
     */
    public function getNegative()
    {
        return $this->negative;
    }

    /**
     * Set pna
     *
     * @param integer $pna
     *
     * @return Film
     */
    public function setPna($pna)
    {
        $this->pna = $pna;

        return $this;
    }

    /**
     * Get pna
     *
     * @return integer
     */
    public function getPna()
    {
        return $this->pna;
    }

    /**
     * Set usRentals
     *
     * @param integer $usRentals
     *
     * @return Film
     */
    public function setUsRentals($usRentals)
    {
        $this->usRentals = $usRentals;

        return $this;
    }

    /**
     * Get usRentals
     *
     * @return integer
     */
    public function getUsRentals()
    {
        return $this->usRentals;
    }

    /**
     * Set foreignRentals
     *
     * @param integer $foreignRentals
     *
     * @return Film
     */
    public function setForeignRentals($foreignRentals)
    {
        $this->foreignRentals = $foreignRentals;

        return $this;
    }

    /**
     * Get foreignRentals
     *
     * @return integer
     */
    public function getForeignRentals()
    {
        return $this->foreignRentals;
    }

    /**
     * Set totalRentals
     *
     * @param integer $totalRentals
     *
     * @return Film
     */
    public function setTotalRentals($totalRentals)
    {
        $this->totalRentals = $totalRentals;

        return $this;
    }

    /**
     * Get totalRentals
     *
     * @return integer
     */
    public function getTotalRentals()
    {
        return $this->totalRentals;
    }

    /**
     * Set usBoxoffice
     *
     * @param integer $usBoxoffice
     *
     * @return Film
     */
    public function setUsBoxoffice($usBoxoffice)
    {
        $this->usBoxoffice = $usBoxoffice;

        return $this;
    }

    /**
     * Get usBoxoffice
     *
     * @return integer
     */
    public function getUsBoxoffice()
    {
        return $this->usBoxoffice;
    }

    /**
     * Set foreignBoxoffice
     *
     * @param integer $foreignBoxoffice
     *
     * @return Film
     */
    public function setForeignBoxoffice($foreignBoxoffice)
    {
        $this->foreignBoxoffice = $foreignBoxoffice;

        return $this;
    }

    /**
     * Get foreignBoxoffice
     *
     * @return integer
     */
    public function getForeignBoxoffice()
    {
        return $this->foreignBoxoffice;
    }

    /**
     * Set totalBoxoffice
     *
     * @param integer $totalBoxoffice
     *
     * @return Film
     */
    public function setTotalBoxoffice($totalBoxoffice)
    {
        $this->totalBoxoffice = $totalBoxoffice;

        return $this;
    }

    /**
     * Get totalBoxoffice
     *
     * @return integer
     */
    public function getTotalBoxoffice()
    {
        return $this->totalBoxoffice;
    }

    /**
     * Set sourceEco
     *
     * @param string $sourceEco
     *
     * @return Film
     */
    public function setSourceEco($sourceEco)
    {
        $this->sourceEco = $sourceEco;

        return $this;
    }

    /**
     * Get sourceEco
     *
     * @return string
     */
    public function getSourceEco()
    {
        return $this->sourceEco;
    }

    /**
     * Set archives
     *
     * @param string $archives
     *
     * @return Film
     */
    public function setArchives($archives)
    {
        $this->archives = $archives;

        return $this;
    }

    /**
     * Get archives
     *
     * @return string
     */
    public function getArchives()
    {
        return $this->archives;
    }

    /**
     * Set deleted
     *
     * @param string $deleted
     *
     * @return Film
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return string
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return Thesaurus
     */
    public function getAdaptation()
    {
        return $this->adaptation;
    }

    /**
     * @param Thesaurus $adaptation
     */
    public function setAdaptation($adaptation)
    {
        $this->adaptation = $adaptation;
    }

    /**
     * Set remake
     *
     * @param string $remake
     *
     * @return Film
     */
    public function setRemake($remake)
    {
        $this->remake = $remake;

        return $this;
    }

    /**
     * Get remake
     *
     * @return string
     */
    public function getRemake()
    {
        return $this->remake;
    }

    /**
     * Set verdict
     *
     * @param string $verdict
     *
     * @return Film
     */
    public function setVerdict($verdict)
    {
        $this->verdict = $verdict;

        return $this;
    }

    /**
     * Get verdict
     *
     * @return string
     */
    public function getVerdict()
    {
        return $this->verdict;
    }

    /**
     * Set pcaTexte
     *
     * @param string $pcaTexte
     *
     * @return Film
     */
    public function setPcaTexte($pcaTexte)
    {
        $this->pcaTexte = $pcaTexte;

        return $this;
    }

    /**
     * Get pcaTexte
     *
     * @return string
     */
    public function getPcaTexte()
    {
        return $this->pcaTexte;
    }

    /**
     * Set legion
     *
     * @param string $legion
     *
     * @return Film
     */
    public function setLegion($legion)
    {
        $this->legion = $legion;

        return $this;
    }

    /**
     * Get legion
     *
     * @return string
     */
    public function getLegion()
    {
        return $this->legion;
    }

    /**
     * Set protestant
     *
     * @param string $protestant
     *
     * @return Film
     */
    public function setProtestant($protestant)
    {
        $this->protestant = $protestant;

        return $this;
    }

    /**
     * Get protestant
     *
     * @return string
     */
    public function getProtestant()
    {
        return $this->protestant;
    }

    /**
     * Set harrisson
     *
     * @param string $harrisson
     *
     * @return Film
     */
    public function setHarrisson($harrisson)
    {
        $this->harrisson = $harrisson;

        return $this;
    }

    /**
     * Get harrisson
     *
     * @return string
     */
    public function getHarrisson()
    {
        return $this->harrisson;
    }

    /**
     * Set bord
     *
     * @param string $bord
     *
     * @return Film
     */
    public function setBord($bord)
    {
        $this->bord = $bord;

        return $this;
    }

    /**
     * Get bord
     *
     * @return string
     */
    public function getBord()
    {
        return $this->bord;
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

    /**
     * Add state
     *
     * @param \AppBundle\Entity\State $state
     *
     * @return Film
     */
    public function addState(\AppBundle\Entity\State $state)
    {
        $this->state[] = $state;

        return $this;
    }

    /**
     * Remove state
     *
     * @param \AppBundle\Entity\State $state
     */
    public function removeState(\AppBundle\Entity\State $state)
    {
        $this->state->removeElement($state);
    }

    /**
     * Get state
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add censorship
     *
     * @param \AppBundle\Entity\Censorship $censorship
     *
     * @return Film
     */
    public function addCensorship(\AppBundle\Entity\Censorship $censorship)
    {
        $this->censorship[] = $censorship;

        return $this;
    }

    /**
     * Remove censorship
     *
     * @param \AppBundle\Entity\Censorship $censorship
     */
    public function removeCensorship(\AppBundle\Entity\Censorship $censorship)
    {
        $this->censorship->removeElement($censorship);
    }

    /**
     * Get censorship
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCensorship()
    {
        return $this->censorship;
    }

    /**
     * @return mixed
     */
    public function getDirectors()
    {
        return $this->directors;
    }

    /**
     * @param mixed $directors
     */
    public function setDirectors($directors)
    {
        $this->directors = $directors;
    }

    /**
     * @return mixed
     */
    public function getIsComplete()
    {
        return $this->isComplete;
    }

    /**
     * @param mixed $isComplete
     */
    public function setIsComplete($isComplete)
    {
        $this->isComplete = $isComplete;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $producers
     */
    public function setProducers($producers)
    {
        $this->producers = $producers;
    }

    /**
     * @return mixed
     */
    public function getNumbers()
    {
        return $this->numbers;
    }

    /**
     * @param mixed $numbers
     */
    public function setNumbers($numbers)
    {
        $this->numbers = $numbers;
    }

    /**
     * @return mixed
     */
    public function getStudios()
    {
        return $this->studios;
    }

    /**
     * @param mixed $studios
     */
    public function setStudios($studios)
    {
        $this->studios = $studios;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDistributors()
    {
        return $this->distributors;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $distributors
     */
    public function setDistributors($distributors)
    {
        $this->distributors = $distributors;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStageshows()
    {
        return $this->stageshows;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $stageshows
     */
    public function setStageshows($stageshows)
    {
        $this->stageshows = $stageshows;
    }

    /**
     * @return string
     */
    public function getSample()
    {
        return $this->sample;
    }

    /**
     * @param string $sample
     */
    public function setSample($sample)
    {
        $this->sample = $sample;
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
    public function getEditors()
    {
        return $this->editors;
    }

    public function addEditors(User $user)
    {
        if ($this->editors->contains($user)) {
            return;
        }

        $this->editors[] = $user;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $editors
     */
    public function setEditors($editors)
    {
        $this->editors = $editors;
    }


    public function __toString()
    {
        $toString = $this->getTitle()." (".$this->getReleased().")";

//        return (string) $this->getTitle();
        return (string) $toString;
    }


}
