<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person
{
    /**
     * @Assert\NotBlank()
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=500, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=5, nullable=true)
     */
    private $gender;


    /**
     * @var integer
     *
     * @ORM\Column(name="firstShow", type="integer", nullable=true)
     */
    private $firstshow;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="person_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $personId;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Film", mappedBy="directors")
     */
    private $filmsDirector;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Film", mappedBy="producers")
     */
    private $filmsProducer;

    /**
     * @ORM\ManyToMany(targetEntity="Number", mappedBy="choregraphers")
     */
    private $numbersChoregrapher;

    /**
     * @ORM\ManyToMany(targetEntity="Number", mappedBy="arrangers")
     */
    private $numbersArranger;

    /**
     * @ORM\ManyToMany(targetEntity="Number", mappedBy="director")
     */
    private $numbersDirector;

    /**
     * @ORM\ManyToMany(targetEntity="Number", mappedBy="performers")
     */
    private $numbersPerformer;

    /**
     * @ORM\ManyToMany(targetEntity="Number", mappedBy="figurants")
     */
    private $numbersFigurant;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stageshow", mappedBy="composers")
     */
    private $stageshowComposer;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stageshow", mappedBy="books")
     */
    private $stageshowBook;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stageshow", mappedBy="lyricists")
     */
    private $stageshowLyricist;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stageshow", mappedBy="choreographers")
     */
    private $stageshowChoreographers;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stageshow", mappedBy="directors")
     */
    private $stageshowDirector;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stageshow", mappedBy="designs")
     */
    private $stageshowDesign;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stagenumber", mappedBy="performers")
     */
    private $stagenumberComposer;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Song", mappedBy="lyricist")
     */
    private $songLyricist;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Song", mappedBy="composer")
     */
    private $songComposer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="person")
     * @ORM\JoinTable(name="person_has_editor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="editors", referencedColumnName="id")
     *   }
     * )
     */
    private $editors;

    /**
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $last_update;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quotation = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Person
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Person
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Person
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Person
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }


    /**
     * Set firstshow
     *
     * @param integer $firstshow
     *
     * @return Person
     */
    public function setFirstshow($firstshow)
    {
        $this->firstshow = $firstshow;

        return $this;
    }

    /**
     * Get firstshow
     *
     * @return integer
     */
    public function getFirstshow()
    {
        return $this->firstshow;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Person
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
    public function getNumbersChoregrapher()
    {
        return $this->numbersChoregrapher;
    }

    /**
     * @param mixed $numbersChoregrapher
     */
    public function setNumbersChoregrapher($numbersChoregrapher)
    {
        $this->numbersChoregrapher = $numbersChoregrapher;
    }

    /**
     * @return mixed
     */
    public function getNumbersArranger()
    {
        return $this->numbersArranger;
    }

    /**
     * @param mixed $numbersArranger
     */
    public function setNumbersArranger($numbersArranger)
    {
        $this->numbersArranger = $numbersArranger;
    }

    /**
     * @return mixed
     */
    public function getNumbersDirector()
    {
        return $this->numbersDirector;
    }

    /**
     * @param mixed $numbersDirector
     */
    public function setNumbersDirector($numbersDirector)
    {
        $this->numbersDirector = $numbersDirector;
    }

    /**
     * @return mixed
     */
    public function getNumbersPerformer()
    {
        return $this->numbersPerformer;
    }

    /**
     * @param mixed $numbersPerformer
     */
    public function setNumbersPerformer($numbersPerformer)
    {
        $this->numbersPerformer = $numbersPerformer;
    }

    /**
     * @return mixed
     */
    public function getNumbersFigurant()
    {
        return $this->numbersFigurant;
    }

    /**
     * @param mixed $numbersFigurant
     */
    public function setNumbersFigurant($numbersFigurant)
    {
        $this->numbersFigurant = $numbersFigurant;
    }


    /**
     * Add numbersChoregrapher
     *
     * @param \AppBundle\Entity\Number $numbersChoregrapher
     *
     * @return Person
     */
    public function addNumbersChoregrapher(\AppBundle\Entity\Number $numbersChoregrapher)
    {
        $this->numbersChoregrapher[] = $numbersChoregrapher;

        return $this;
    }

    /**
     * Remove numbersChoregrapher
     *
     * @param \AppBundle\Entity\Number $numbersChoregrapher
     */
    public function removeNumbersChoregrapher(\AppBundle\Entity\Number $numbersChoregrapher)
    {
        $this->numbersChoregrapher->removeElement($numbersChoregrapher);
    }

    /**
     * Add numbersArranger
     *
     * @param \AppBundle\Entity\Number $numbersArranger
     *
     * @return Person
     */
    public function addNumbersArranger(\AppBundle\Entity\Number $numbersArranger)
    {
        $this->numbersArranger[] = $numbersArranger;

        return $this;
    }

    /**
     * Remove numbersArranger
     *
     * @param \AppBundle\Entity\Number $numbersArranger
     */
    public function removeNumbersArranger(\AppBundle\Entity\Number $numbersArranger)
    {
        $this->numbersArranger->removeElement($numbersArranger);
    }

    /**
     * Add numbersDirector
     *
     * @param \AppBundle\Entity\Number $numbersDirector
     *
     * @return Person
     */
    public function addNumbersDirector(\AppBundle\Entity\Number $numbersDirector)
    {
        $this->numbersDirector[] = $numbersDirector;

        return $this;
    }

    /**
     * Remove numbersDirector
     *
     * @param \AppBundle\Entity\Number $numbersDirector
     */
    public function removeNumbersDirector(\AppBundle\Entity\Number $numbersDirector)
    {
        $this->numbersDirector->removeElement($numbersDirector);
    }

    /**
     * Add numbersPerformer
     *
     * @param \AppBundle\Entity\Number $numbersPerformer
     *
     * @return Person
     */
    public function addNumbersPerformer(\AppBundle\Entity\Number $numbersPerformer)
    {
        $this->numbersPerformer[] = $numbersPerformer;

        return $this;
    }

    /**
     * Remove numbersPerformer
     *
     * @param \AppBundle\Entity\Number $numbersPerformer
     */
    public function removeNumbersPerformer(\AppBundle\Entity\Number $numbersPerformer)
    {
        $this->numbersPerformer->removeElement($numbersPerformer);
    }

    /**
     * Add numbersFigurant
     *
     * @param \AppBundle\Entity\Number $numbersFigurant
     *
     * @return Person
     */
    public function addNumbersFigurant(\AppBundle\Entity\Number $numbersFigurant)
    {
        $this->numbersFigurant[] = $numbersFigurant;

        return $this;
    }

    /**
     * Remove numbersFigurant
     *
     * @param \AppBundle\Entity\Number $numbersFigurant
     */
    public function removeNumbersFigurant(\AppBundle\Entity\Number $numbersFigurant)
    {
        $this->numbersFigurant->removeElement($numbersFigurant);
    }

    /**
     * Add songLyricist
     *
     * @param \AppBundle\Entity\Song $songLyricist
     *
     * @return Person
     */
    public function addSongLyricist(\AppBundle\Entity\Song $songLyricist)
    {
        $this->songLyricist[] = $songLyricist;

        return $this;
    }

    /**
     * Remove songLyricist
     *
     * @param \AppBundle\Entity\Song $songLyricist
     */
    public function removeSongLyricist(\AppBundle\Entity\Song $songLyricist)
    {
        $this->songLyricist->removeElement($songLyricist);
    }

    /**
     * Get songLyricist
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSongLyricist()
    {
        return $this->songLyricist;
    }

    /**
     * Add editor
     *
     * @param \AppBundle\Entity\User $editor
     *
     * @return Person
     */
    public function addEditor(\AppBundle\Entity\User $editor)
    {
        $this->editors[] = $editor;

        return $this;
    }

    /**
     * Remove editor
     *
     * @param \AppBundle\Entity\User $editor
     */
    public function removeEditor(\AppBundle\Entity\User $editor)
    {
        $this->editors->removeElement($editor);
    }

    /**
     * Add songComposer
     *
     * @param \AppBundle\Entity\Song $songComposer
     *
     * @return Person
     */
    public function addSongComposer(\AppBundle\Entity\Song $songComposer)
    {
        $this->songComposer[] = $songComposer;

        return $this;
    }

    /**
     * Remove songComposer
     *
     * @param \AppBundle\Entity\Song $songComposer
     */
    public function removeSongComposer(\AppBundle\Entity\Song $songComposer)
    {
        $this->songComposer->removeElement($songComposer);
    }

    /**
     * Get songComposer
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSongComposer()
    {
        return $this->songComposer;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getQuotation()
    {
        return $this->quotation;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $quotation
     */
    public function setQuotation($quotation)
    {
        $this->quotation = $quotation;
    }

    /**
     * @return mixed
     */
    public function getFilmsDirector()
    {
        return $this->filmsDirector;
    }

    /**
     * @param mixed $filmsDirector
     */
    public function setFilmsDirector($filmsDirector)
    {
        $this->filmsDirector = $filmsDirector;
    }

    /**
     * @return mixed
     */
    public function getFilmsProducer()
    {
        return $this->filmsProducer;
    }

    /**
     * @param mixed $filmsProducer
     */
    public function setFilmsProducer($filmsProducer)
    {
        $this->filmsProducer = $filmsProducer;
    }

    /**
     * @return mixed
     */
    public function getStageshowComposer()
    {
        return $this->stageshowComposer;
    }

    /**
     * @param mixed $stageshowComposer
     */
    public function setStageshowComposer($stageshowComposer)
    {
        $this->stageshowComposer = $stageshowComposer;
    }

    /**
     * @return mixed
     */
    public function getStageshowBook()
    {
        return $this->stageshowBook;
    }

    /**
     * @param mixed $stageshowBook
     */
    public function setStageshowBook($stageshowBook)
    {
        $this->stageshowBook = $stageshowBook;
    }

    /**
     * @return mixed
     */
    public function getStageshowLyricist()
    {
        return $this->stageshowLyricist;
    }

    /**
     * @param mixed $stageshowLyricist
     */
    public function setStageshowLyricist($stageshowLyricist)
    {
        $this->stageshowLyricist = $stageshowLyricist;
    }

    /**
     * @return mixed
     */
    public function getStageshowChoreographers()
    {
        return $this->stageshowChoreographers;
    }

    /**
     * @param mixed $stageshowChoreographers
     */
    public function setStageshowChoreographers($stageshowChoreographers)
    {
        $this->stageshowChoreographers = $stageshowChoreographers;
    }

    /**
     * @return mixed
     */
    public function getStageshowDirector()
    {
        return $this->stageshowDirector;
    }

    /**
     * @param mixed $stageshowDirector
     */
    public function setStageshowDirector($stageshowDirector)
    {
        $this->stageshowDirector = $stageshowDirector;
    }

    /**
     * @return mixed
     */
    public function getStageshowDesign()
    {
        return $this->stageshowDesign;
    }

    /**
     * @param mixed $stageshowDesign
     */
    public function setStageshowDesign($stageshowDesign)
    {
        $this->stageshowDesign = $stageshowDesign;
    }

    /**
     * @return mixed
     */
    public function getStagenumberComposer()
    {
        return $this->stagenumberComposer;
    }

    /**
     * @param mixed $stagenumberComposer
     */
    public function setStagenumberComposer($stagenumberComposer)
    {
        $this->stagenumberComposer = $stagenumberComposer;
    }


    public function __toString()
    {
        return $this->getName();
    }
}
