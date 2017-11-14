<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Stagenumber
 *
 * @ORM\Table(name="stagenumber")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StagenumberRepository")
 */
class Stagenumber
{

    /**
     * @var integer
     *
     * @ORM\Column(name="stagenumber_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $stagenumberId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=true)
     */
    private $order;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="stagenumber_has_musicalthesaurus",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="musical_thesaurus_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $musical_thesaurus;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="stagenumber_has_dancingtype",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dancingtype_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $dancing_type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="stagenumber_has_dancesubgenre",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dancesubgenre_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $dance_subgenre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="stagenumber_has_dancecontent",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dancecontent_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $dance_content;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="stagenumber_has_genre",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="genre_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $genre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="stagenumber_has_generalmood",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="general_mood_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $general_mood;

    /**
     * @var string
     *
     * @ORM\Column(name="characters", type="string", length=500,  nullable=true)
     */
    private $characters;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="ibdb", type="integer", nullable=true)
     */
    private $ibdb;


    /**
     * @var string
     *
     * @ORM\Column(name="setting", type="text", length=1000, nullable=true)
     */
    private $setting;

    /**
     * @var \AppBundle\Entity\Stageshow
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stageshow",inversedBy="stagenumbers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="stageshow_id", referencedColumnName="stageshow_id", nullable=false)
     * })
     */
    private $stageshow;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="stagenumber_has_costume",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="costume_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $costumes;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Number", mappedBy="stagenumbers")
     */
    private $number;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Song", mappedBy="stagenumbers")
     */
    private $song;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="stagenumber_has_dancemble",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dancemble_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $dancemble;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="stagenumber_has_musensemble",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="musensemble_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $musensemble;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="stagenumber_has_performer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $performers;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cast_id", referencedColumnName="thesaurus_id")
     * })
     */
    private $cast;

    /**
     * @var boolean
     *
     * @ORM\Column(name="selected", type="boolean", nullable=true)
     */
    private $selected;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=500, nullable=true)
     */
    private $code;

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
     * @ORM\JoinTable(name="stagenumber_has_editor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
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
        $this->number = new \Doctrine\Common\Collections\ArrayCollection();
        $this->song = new \Doctrine\Common\Collections\ArrayCollection();
        $this->editors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date_creation = new \DateTime();
        $this->last_update = new \DateTime();
    }

    /**
     * @return int
     */
    public function getStagenumberId()
    {
        return $this->stagenumberId;
    }

    /**
     * @param int $stagenumberId
     */
    public function setStagenumberId($stagenumberId)
    {
        $this->stagenumberId = $stagenumberId;
    }



    /**
     * Set title
     *
     * @param string $title
     *
     * @return Stagenumber
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
     * Set order
     *
     * @param integer $order
     *
     * @return Stagenumber
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Stagenumber
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ibdb
     *
     * @param integer $ibdb
     *
     * @return Stagenumber
     */
    public function setIbdb($ibdb)
    {
        $this->ibdb = $ibdb;

        return $this;
    }

    /**
     * Get ibdb
     *
     * @return integer
     */
    public function getIbdb()
    {
        return $this->ibdb;
    }


    /**
     * @return string
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * @param string $setting
     */
    public function setSetting($setting)
    {
        $this->setting = $setting;
    }


    /**
     * Set stageshow
     *
     * @param \AppBundle\Entity\Stageshow $stageshow
     *
     * @return Stagenumber
     */
    public function setStageshow(\AppBundle\Entity\Stageshow $stageshow = null)
    {
        $this->stageshow = $stageshow;

        return $this;
    }

    /**
     * Get stageshow
     *
     * @return \AppBundle\Entity\Stageshow
     */
    public function getStageshow()
    {
        return $this->stageshow;
    }

    /**
     * Add number
     *
     * @param \AppBundle\Entity\Number $number
     *
     * @return Stagenumber
     */
    public function addNumber(\AppBundle\Entity\Number $number)
    {
        $this->number[] = $number;

        return $this;
    }

    /**
     * Remove number
     *
     * @param \AppBundle\Entity\Number $number
     */
    public function removeNumber(\AppBundle\Entity\Number $number)
    {
        $this->number->removeElement($number);
    }

    /**
     * Get number
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Add song
     *
     * @param \AppBundle\Entity\Song $song
     *
     * @return Stagenumber
     */
    public function addSong(\AppBundle\Entity\Song $song)
    {
        $this->song[] = $song;

        return $this;
    }

    /**
     * Remove song
     *
     * @param \AppBundle\Entity\Song $song
     */
    public function removeSong(\AppBundle\Entity\Song $song)
    {
        $this->song->removeElement($song);
    }

    /**
     * Get song
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSong()
    {
        return $this->song;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMusensemble()
    {
        return $this->musensemble;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $musensemble
     */
    public function setMusensemble($musensemble)
    {
        $this->musensemble = $musensemble;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDancemble()
    {
        return $this->dancemble;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $dancemble
     */
    public function setDancemble($dancemble)
    {
        $this->dancemble = $dancemble;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMusicalThesaurus()
    {
        return $this->musical_thesaurus;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $musical_thesaurus
     */
    public function setMusicalThesaurus($musical_thesaurus)
    {
        $this->musical_thesaurus = $musical_thesaurus;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDancingType()
    {
        return $this->dancing_type;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $dancing_type
     */
    public function setDancingType($dancing_type)
    {
        $this->dancing_type = $dancing_type;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDanceSubgenre()
    {
        return $this->dance_subgenre;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $dance_subgenre
     */
    public function setDanceSubgenre($dance_subgenre)
    {
        $this->dance_subgenre = $dance_subgenre;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDanceContent()
    {
        return $this->dance_content;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $dance_content
     */
    public function setDanceContent($dance_content)
    {
        $this->dance_content = $dance_content;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return string
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @param string $characters
     */
    public function setCharacters($characters)
    {
        $this->characters = $characters;
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
    public function getPerformers()
    {
        return $this->performers;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $performers
     */
    public function setPerformers($performers)
    {
        $this->performers = $performers;
    }

    /**
     * @return Thesaurus
     */
    public function getCast()
    {
        return $this->cast;
    }

    /**
     * @param Thesaurus $cast
     */
    public function setCast($cast)
    {
        $this->cast = $cast;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return bool
     */
    public function isSelected()
    {
        return $this->selected;
    }

    /**
     * @param bool $selected
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCostumes()
    {
        return $this->costumes;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $costumes
     */
    public function setCostumes($costumes)
    {
        $this->costumes = $costumes;
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


    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGeneralMood()
    {
        return $this->general_mood;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $general_mood
     */
    public function setGeneralMood($general_mood)
    {
        $this->general_mood = $general_mood;
    }


    public function __toString()
    {
        return $this->getTitle();
    }



}
