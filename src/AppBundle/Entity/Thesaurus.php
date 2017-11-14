<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Thesaurus
 *
 * @ORM\Table(name="thesaurus")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ThesaurusRepository")
 */
class Thesaurus
{

    /**
     * @var integer
     *
     * @ORM\Column(name="thesaurus_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=500, nullable=false)
     */
    private $title;

    /**
     * @var \AppBundle\Entity\Code
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Code")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_id", referencedColumnName="code_id", nullable=false)
     * })
     */
    private $code;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="type", type="string", length=255, nullable=false)
//     */
//    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="definition", type="text", length=65535, nullable=true)
     */
    private $definition;

    /**
     * @var string
     *
     * @ORM\Column(name="example", type="text", length=65535, nullable=true)
     */
    private $example;

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
     * @ORM\JoinTable(name="thesaurus_has_editor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="thesaurus_id", referencedColumnName="thesaurus_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="editors", referencedColumnName="id")
     *   }
     * )
     */
    private $editors;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Number", mappedBy="costumes")
     */
    private $numbers_with_costume;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Number", mappedBy="structure")
     */
    private $numbers_with_structure;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->editors = new ArrayCollection();
        $this->numbers_with_structure = new ArrayCollection();
        $this->numbers_with_costume = new ArrayCollection();
        $this->date_creation = new \DateTime();
        $this->last_update = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Thesaurus
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Thesaurus
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Thesaurus
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set definition
     *
     * @param string $definition
     *
     * @return Thesaurus
     */
    public function setDefinition($definition)
    {
        $this->definition = $definition;

        return $this;
    }

    /**
     * Get definition
     *
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Set example
     *
     * @param string $example
     *
     * @return Thesaurus
     */
    public function setExample($example)
    {
        $this->example = $example;

        return $this;
    }

    /**
     * Get example
     *
     * @return string
     */
    public function getExample()
    {
        return $this->example;
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
    public function getNumbersWithStructure()
    {
        return $this->numbers_with_structure;
    }

    /**
     * @param mixed $numbers_with_structure
     */
    public function setNumbersWithStructure($numbers_with_structure)
    {
        $this->numbers_with_structure = $numbers_with_structure;
    }

    /**
     * @return mixed
     */
    public function getNumbersWithCostume()
    {
        return $this->numbers_with_costume;
    }

    /**
     * @param mixed $numbers_with_costume
     */
    public function setNumbersWithCostume($numbers_with_costume)
    {
        $this->numbers_with_costume = $numbers_with_costume;
    }



    public function __toString()
    {
        return $this->getTitle();
    }


}
