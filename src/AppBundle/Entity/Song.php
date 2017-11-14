<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Song
 *
 * @ORM\Table(name="song")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SongRepository")
 */
class Song
{

    /**
     * @var integer
     *
     * @ORM\Column(name="song_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $songId;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=500, nullable=false)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="date", type="integer", nullable=true)
     */
    private $date;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="song_has_songtype",
     *   joinColumns={
     *     @ORM\JoinColumn(name="song_id", referencedColumnName="song_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="songtype_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $songtype;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Radio", inversedBy="song")
     * @ORM\JoinTable(name="song_has_radio",
     *   joinColumns={
     *     @ORM\JoinColumn(name="song_id", referencedColumnName="song_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="radio_id", referencedColumnName="radio_id")
     *   }
     * )
     */
    private $radio;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stagenumber", inversedBy="song")
     * @ORM\JoinTable(name="song_has_stagenumber",
     *   joinColumns={
     *     @ORM\JoinColumn(name="song_id", referencedColumnName="song_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   }
     * )
     */
    private $stagenumbers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Disc", inversedBy="song")
     * @ORM\JoinTable(name="song_has_disc",
     *   joinColumns={
     *     @ORM\JoinColumn(name="song_id", referencedColumnName="song_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="disc_id", referencedColumnName="disc_id")
     *   }
     * )
     */
    private $disc;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="song_has_lyricist",
     *   joinColumns={
     *     @ORM\JoinColumn(name="song_id", referencedColumnName="song_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $lyricist;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="song_has_composer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="song_id", referencedColumnName="song_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="composer_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $composer;

    /**
     * @var string
     *
     * @ORM\Column(name="lyrics", type="text", length=16777215, nullable=true)
     */
    private $lyrics;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tv", inversedBy="song")
     * @ORM\JoinTable(name="song_has_tv",
     *   joinColumns={
     *     @ORM\JoinColumn(name="song_id", referencedColumnName="song_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="TV_id", referencedColumnName="TV_id")
     *   }
     * )
     */
    private $tv;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Number", mappedBy="song")
     */
    private $number;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="song_has_editor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="song_id", referencedColumnName="song_id")
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
        $this->radio = new \Doctrine\Common\Collections\ArrayCollection();
        $this->stagenumbers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->disc = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tv = new \Doctrine\Common\Collections\ArrayCollection();
        $this->number = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Song
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
     * Set date
     *
     * @param string $date
     *
     * @return Song
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get songId
     *
     * @return integer
     */
    public function getSongId()
    {
        return $this->songId;
    }

    /**
     * Add radio
     *
     * @param \AppBundle\Entity\Radio $radio
     *
     * @return Song
     */
    public function addRadio(\AppBundle\Entity\Radio $radio)
    {
        $this->radio[] = $radio;

        return $this;
    }

    /**
     * Remove radio
     *
     * @param \AppBundle\Entity\Radio $radio
     */
    public function removeRadio(\AppBundle\Entity\Radio $radio)
    {
        $this->radio->removeElement($radio);
    }

    /**
     * Get radio
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRadio()
    {
        return $this->radio;
    }

    /**
     * Add stagenumber
     *
     * @param \AppBundle\Entity\Stagenumber $stagenumber
     *
     * @return Song
     */
    public function addStagenumber(\AppBundle\Entity\Stagenumber $stagenumber)
    {
        $this->stagenumber[] = $stagenumber;

        return $this;
    }

    /**
     * Remove stagenumber
     *
     * @param \AppBundle\Entity\Stagenumber $stagenumber
     */
    public function removeStagenumber(\AppBundle\Entity\Stagenumber $stagenumber)
    {
        $this->stagenumber->removeElement($stagenumber);
    }

    /**
     * Get stagenumber
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStagenumber()
    {
        return $this->stagenumber;
    }

    /**
     * Add disc
     *
     * @param \AppBundle\Entity\Disc $disc
     *
     * @return Song
     */
    public function addDisc(\AppBundle\Entity\Disc $disc)
    {
        $this->disc[] = $disc;

        return $this;
    }

    /**
     * Remove disc
     *
     * @param \AppBundle\Entity\Disc $disc
     */
    public function removeDisc(\AppBundle\Entity\Disc $disc)
    {
        $this->disc->removeElement($disc);
    }

    /**
     * Get disc
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisc()
    {
        return $this->disc;
    }


    /**
     * Add tv
     *
     * @param \AppBundle\Entity\Tv $tv
     *
     * @return Song
     */
    public function addTv(\AppBundle\Entity\Tv $tv)
    {
        $this->tv[] = $tv;

        return $this;
    }

    /**
     * Remove tv
     *
     * @param \AppBundle\Entity\Tv $tv
     */
    public function removeTv(\AppBundle\Entity\Tv $tv)
    {
        $this->tv->removeElement($tv);
    }

    /**
     * Get tv
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTv()
    {
        return $this->tv;
    }

    /**
     * Add number
     *
     * @param \AppBundle\Entity\Number $number
     *
     * @return Song
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

    public function __toString()
    {
        return $this->getTitle();
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLyricist()
    {
        return $this->lyricist;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $lyricist
     */
    public function setLyricist($lyricist)
    {
        $this->lyricist = $lyricist;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComposer()
    {
        return $this->composer;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $composer
     */
    public function setComposer($composer)
    {
        $this->composer = $composer;
    }

    /**
     * @return string
     */
    public function getLyrics()
    {
        return $this->lyrics;
    }

    /**
     * @param string $lyrics
     */
    public function setLyrics($lyrics)
    {
        $this->lyrics = $lyrics;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSongtype()
    {
        return $this->songtype;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $songtype
     */
    public function setSongtype($songtype)
    {
        $this->songtype = $songtype;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStagenumbers()
    {
        return $this->stagenumbers;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $stagenumbers
     */
    public function setStagenumbers($stagenumbers)
    {
        $this->stagenumbers = $stagenumbers;
    }



}
