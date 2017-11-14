<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Number
 *
 * @ORM\Table(name="number", indexes={@ORM\Index(name="fk_number_film1_idx", columns={"film_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NumberRepository")
 */
class Number
{

    /**
     * @var integer
     *
     * @ORM\Column(name="number_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @var \AppBundle\Entity\Film
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Film", inversedBy="numbers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="film_id", referencedColumnName="film_id", nullable=false)
     * })
     */
    private $film;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="number")
     * @ORM\JoinTable(name="number_has_editor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
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



    // -- Title

    /**
     * @Assert\NotBlank()
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentTitle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeTitle;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_title",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_title", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationTitle;


    // -- Director

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="number_has_director",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $director;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_director",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_director", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationDirector;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeDirector;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentDirector;


    // -- Outlines

    /**
     * @var integer
     *
     * @ORM\Column(name="begin_tc", type="integer", nullable=true)
     */
    private $beginTc;

    /**
     * @var integer
     *
     * @ORM\Column(name="end_tc", type="integer", nullable=true)
     */
    private $endTc;

    /**
     * @var integer
     *
     * @ORM\Column(name="length", type="integer", nullable=true)
     */
    private $length;

    /**
     * @var \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="begin_thesaurus", referencedColumnName="thesaurus_id")
     * })
     */
    private $begin_thesaurus;

    /**
     * @var \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ending_thesaurus", referencedColumnName="thesaurus_id")
     * })
     */
    private $ending_thesaurus;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="completeness_id", referencedColumnName="thesaurus_id")
     * })
     */
    private $completeness_thesaurus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_completoptions",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="completoptions_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $complet_options;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentTc;

    /**
     * @ORM\Column(type="integer",  nullable=true)
     */
    private $completeTc;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_tc",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_tc", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationTc;


    // -- Structure

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="structure_id", referencedColumnName="thesaurus_id")
     * })
     */
    private $structure;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentStructure;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeStructure;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_structure",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_structure", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationStructure;


    // -- Shots

    /**
     * @Assert\Range(min=0, minMessage="Negative number of shots! Come on...")
     *
     * @var integer
     *
     * @ORM\Column(name="shots", type="integer", nullable=true)
     */
    private $shots;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentShots;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeShots;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_shots",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_shots", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationShots;



    // -- Performers

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="performance_thesaurus_id", referencedColumnName="thesaurus_id")
     * })
     */
    private $performance_thesaurus;

    /**
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person")
     * @ORM\JoinTable(name="number_has_performer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $performers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person", inversedBy="numbers_figurant")
     * @ORM\JoinTable(name="number_has_figurant",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $figurants;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cast_id", referencedColumnName="thesaurus_id")
     * })
     */
    private $cast;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completePerformance;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentPerformance;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_performance",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_performance", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationPerformance;



    // -- Backstage

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="spectators_thesaurus_id", referencedColumnName="thesaurus_id")
     * })
     */
    private $spectators_thesaurus;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="diegetic_thesaurus_id", referencedColumnName="thesaurus_id")
     * })
     */
    private $diegetic_thesaurus;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="musician_thesaurus_id", referencedColumnName="thesaurus_id")
     * })
     */
    private $musician_thesaurus;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeBackstage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentBackstage;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_backstage",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_backstage", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationBackstage;



    // -- Theme

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="numbers_with_costume")
     * @ORM\JoinTable(name="number_has_costume",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="number_has_stereotype",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="stereotype_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $stereotype;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="number_has_diegeticplace",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="diegetic_place_thesaurus_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $diegetic_place_thesaurus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="number_has_generallocalisation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="general_localisation_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $general_localisation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="number_has_imaginary",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="imaginary_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $imaginary;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_exoticismthesaurus",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="exoticism_thesaurus_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $exoticism_thesaurus;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentTheme;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeTheme;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_theme",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_theme", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationTheme;

    // -- Tone

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_generalmood",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="general_mood_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $general_mood;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_genre",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="genre_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $genre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentMood;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeMood;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_mood",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_mood", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationMood;



    // -- Dance

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person", inversedBy="numbersChoregrapher")
     * @ORM\JoinTable(name="number_has_choregraph",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $choregraphers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_dancemble",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_dancingtype",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_dancesubgenre",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_dancecontent",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dancecontent_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $dance_content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentDance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeDance;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_dance",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_dance", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationDance;


    // -- Music

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Song", inversedBy="number")
     * @ORM\JoinTable(name="number_has_song",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="song_id", referencedColumnName="song_id")
     *   }
     * )
     */
    private $song;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_musensemble",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="musensemble_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $musensemble;

    /**
     * @var string
     *
     * @ORM\Column(name="dubbing", type="string", length=500, nullable=true)
     */
    private $dubbing;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tempo_thesaurus", referencedColumnName="thesaurus_id")
     * })
     */
    private $tempo_thesaurus;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_musicalthesaurus",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person", inversedBy="numbers_arranger")
     * @ORM\JoinTable(name="number_has_arranger",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     *   }
     * )
     */
    private $arrangers;

    /**
     * @var string
     *
     * @ORM\Column(name="arranger_comment", type="string", length=500, nullable=true)
     */
    private $arrangerComment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentMusic;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeMusic;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_music",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_music", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationMusic;

    // -- Source(s)

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_source",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="source_thesaurus_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $source_thesaurus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stagenumber", inversedBy="number")
     * @ORM\JoinTable(name="number_has_stagenumber",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="stagenumber_id", referencedColumnName="stagenumber_id")
     *   }
     * )
     */
    private $stagenumbers;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeReference;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentReference;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_reference",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_reference", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationReference;


    // -- Complement

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", inversedBy="number")
     * @ORM\JoinTable(name="number_has_quotationthesaurus",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="quotation_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $quotation_thesaurus;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $quotation_text;

    /**
     * @var string
     *
     * @ORM\Column(name="lyrics", type="text", length=16777215, nullable=true)
     */
    private $lyrics;

    /**
     * @var integer
     *
     * @ORM\Column(name="cost", type="integer", nullable=true)
     */
    private $cost;

    /**
     * @var string
     *
     * @ORM\Column(name="cost_comment", type="text", length=65535, nullable=true)
     */
    private $costComment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completeCost;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Validation", cascade= {"persist"})
     * @ORM\JoinTable(name="number_has_validation_cost",
     *   joinColumns={
     *     @ORM\JoinColumn(name="number_id", referencedColumnName="number_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="validation_cost", referencedColumnName="validation_id")
     *   }
     * )
     */
    private $validationCost;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->song = new \Doctrine\Common\Collections\ArrayCollection();
        $this->place = new \Doctrine\Common\Collections\ArrayCollection();
        $this->performers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->editors = new \Doctrine\Common\Collections\ArrayCollection();

    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Number
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
     * Set validationTitle
     *
     * @param integer $validationTitle
     *
     * @return Number
     */
    public function setValidationTitle($validationTitle)
    {
        $this->validationTitle = $validationTitle;

        return $this;
    }

    /**
     * Get validationTitle
     *
     * @return integer
     */
    public function getValidationTitle()
    {
        return $this->validationTitle;
    }

    /**
     * Set beginTc
     *
     * @param integer $beginTc
     *
     * @return Number
     */
    public function setBeginTc($beginTc)
    {
        $this->beginTc = $beginTc;

        return $this;
    }

    /**
     * Get beginTc
     *
     * @return integer
     */
    public function getBeginTc()
    {
        return $this->beginTc;
    }

    /**
     * Set endTc
     *
     * @param integer $endTc
     *
     * @return Number
     */
    public function setEndTc($endTc)
    {
        $this->endTc = $endTc;

        return $this;
    }

    /**
     * Get endTc
     *
     * @return integer
     */
    public function getEndTc()
    {
        return $this->endTc;
    }

    /**
     * Set length
     *
     * @param integer $length
     *
     * @return Number
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
     * Set validationTc
     *
     * @param integer $validationTc
     *
     * @return Number
     */
    public function setValidationTc($validationTc)
    {
        $this->validationTc = $validationTc;

        return $this;
    }

    /**
     * Get validationTc
     *
     * @return integer
     */
    public function getValidationTc()
    {
        return $this->validationTc;
    }


    /**
     * Set validationStructure
     *
     * @param integer $validationStructure
     *
     * @return Number
     */
    public function setValidationStructure($validationStructure)
    {
        $this->validationStructure = $validationStructure;

        return $this;
    }

    /**
     * Get validationStructure
     *
     * @return integer
     */
    public function getValidationStructure()
    {
        return $this->validationStructure;
    }

    /**
     * Set shots
     *
     * @param integer $shots
     *
     * @return Number
     */
    public function setShots($shots)
    {
        $this->shots = $shots;

        return $this;
    }

    /**
     * Get shots
     *
     * @return integer
     */
    public function getShots()
    {
        return $this->shots;
    }

    /**
     * Set validationShots
     *
     * @param integer $validationShots
     *
     * @return Number
     */
    public function setValidationShots($validationShots)
    {
        $this->validationShots = $validationShots;

        return $this;
    }

    /**
     * Get validationShots
     *
     * @return integer
     */
    public function getValidationShots()
    {
        return $this->validationShots;
    }

    /**
     * Set validationPerformance
     *
     * @param integer $validationPerformance
     *
     * @return Number
     */
    public function setValidationPerformance($validationPerformance)
    {
        $this->validationPerformance = $validationPerformance;

        return $this;
    }

    /**
     * Get validationPerformance
     *
     * @return integer
     */
    public function getValidationPerformance()
    {
        return $this->validationPerformance;
    }

    /**
     * Set validationBackstage
     *
     * @param integer $validationBackstage
     *
     * @return Number
     */
    public function setValidationBackstage($validationBackstage)
    {
        $this->validationBackstage = $validationBackstage;

        return $this;
    }

    /**
     * Get validationBackstage
     *
     * @return integer
     */
    public function getValidationBackstage()
    {
        return $this->validationBackstage;
    }

    /**
     * Set validationTheme
     *
     * @param integer $validationTheme
     *
     * @return Number
     */
    public function setValidationTheme($validationTheme)
    {
        $this->validationTheme = $validationTheme;

        return $this;
    }

    /**
     * Get validationTheme
     *
     * @return integer
     */
    public function getValidationTheme()
    {
        return $this->validationTheme;
    }

    /**
     * Set validationMood
     *
     * @param integer $validationMood
     *
     * @return Number
     */
    public function setValidationMood($validationMood)
    {
        $this->validationMood = $validationMood;

        return $this;
    }

    /**
     * Get validationMood
     *
     * @return integer
     */
    public function getValidationMood()
    {
        return $this->validationMood;
    }

    /**
     * Set validationDance
     *
     * @param integer $validationDance
     *
     * @return Number
     */
    public function setValidationDance($validationDance)
    {
        $this->validationDance = $validationDance;

        return $this;
    }

    /**
     * Get validationDance
     *
     * @return integer
     */
    public function getValidationDance()
    {
        return $this->validationDance;
    }

    /**
     * Set dubbing
     *
     * @param string $dubbing
     *
     * @return Number
     */
    public function setDubbing($dubbing)
    {
        $this->dubbing = $dubbing;

        return $this;
    }

    /**
     * Get dubbing
     *
     * @return string
     */
    public function getDubbing()
    {
        return $this->dubbing;
    }

    /**
     * Set arrangerComment
     *
     * @param string $arrangerComment
     *
     * @return Number
     */
    public function setArrangerComment($arrangerComment)
    {
        $this->arrangerComment = $arrangerComment;

        return $this;
    }

    /**
     * Get arrangerComment
     *
     * @return string
     */
    public function getArrangerComment()
    {
        return $this->arrangerComment;
    }

    /**
     * Set lyrics
     *
     * @param string $lyrics
     *
     * @return Number
     */
    public function setLyrics($lyrics)
    {
        $this->lyrics = $lyrics;

        return $this;
    }

    /**
     * Get lyrics
     *
     * @return string
     */
    public function getLyrics()
    {
        return $this->lyrics;
    }

    /**
     * Set validationMusic
     *
     * @param integer $validationMusic
     *
     * @return Number
     */
    public function setValidationMusic($validationMusic)
    {
        $this->validationMusic = $validationMusic;

        return $this;
    }

    /**
     * Get validationMusic
     *
     * @return integer
     */
    public function getValidationMusic()
    {
        return $this->validationMusic;
    }

    /**
     * Set validationDirector
     *
     * @param integer $validationDirector
     *
     * @return Number
     */
    public function setValidationDirector($validationDirector)
    {
        $this->validationDirector = $validationDirector;

        return $this;
    }

    /**
     * Get validationDirector
     *
     * @return integer
     */
    public function getValidationDirector()
    {
        return $this->validationDirector;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     *
     * @return Number
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set costComment
     *
     * @param string $costComment
     *
     * @return Number
     */
    public function setCostComment($costComment)
    {
        $this->costComment = $costComment;

        return $this;
    }

    /**
     * Get costComment
     *
     * @return string
     */
    public function getCostComment()
    {
        return $this->costComment;
    }

    /**
     * Set validationCost
     *
     * @param integer $validationCost
     *
     * @return Number
     */
    public function setValidationCost($validationCost)
    {
        $this->validationCost = $validationCost;

        return $this;
    }

    /**
     * Get validationCost
     *
     * @return integer
     */
    public function getValidationCost()
    {
        return $this->validationCost;
    }


    /**
     * Set validationReference
     *
     * @param integer $validationReference
     *
     * @return Number
     */
    public function setValidationReference($validationReference)
    {
        $this->validationReference = $validationReference;

        return $this;
    }

    /**
     * Get validationReference
     *
     * @return integer
     */
    public function getValidationReference()
    {
        return $this->validationReference;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getNumberId()
    {
        return $this->id;
    }

    /**
     * Get Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set film
     *
     * @param \AppBundle\Entity\Film $film
     *
     * @return Number
     */
    public function setFilm(\AppBundle\Entity\Film $film = null)
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return \AppBundle\Entity\Film
     */
    public function getFilm()
    {
        return $this->film;
    }

    /**
     * Add song
     *
     * @param \AppBundle\Entity\Song $song
     *
     * @return Number
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
     * @return Thesaurus
     */
    public function getBeginThesaurus()
    {
        return $this->begin_thesaurus;
    }

    /**
     * @param Thesaurus $begin_thesaurus
     */
    public function setBeginThesaurus($begin_thesaurus)
    {
        $this->begin_thesaurus = $begin_thesaurus;
    }

    /**
     * @return Thesaurus
     */
    public function getEndingThesaurus()
    {
        return $this->ending_thesaurus;
    }

    /**
     * @param Thesaurus $ending_thesaurus
     */
    public function setEndingThesaurus($ending_thesaurus)
    {
        $this->ending_thesaurus = $ending_thesaurus;
    }

    /**
     * @return Thesaurus
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * @param Thesaurus $structure
     */
    public function setStructure($structure)
    {
        $this->structure = $structure;
    }

    /**
     * @return Thesaurus
     */
    public function getMusensemble()
    {
        return $this->musensemble;
    }

    /**
     * @param Thesaurus $musensemble
     */
    public function setMusensemble($musensemble)
    {
        $this->musensemble = $musensemble;
    }


    /**
     * @return Thesaurus
     */
    public function getCostumes()
    {
        return $this->costumes;
    }

    /**
     * @param Thesaurus $costumes
     */
    public function setCostumes($costumes)
    {
        $this->costumes = $costumes;
    }

    /**
     * @return Thesaurus
     */
    public function getStereotype()
    {
        return $this->stereotype;
    }

    /**
     * @param Thesaurus $stereotype
     */
    public function setStereotype($stereotype)
    {
        $this->stereotype = $stereotype;
    }

    /**
     * @return Thesaurus
     */
    public function getSourceThesaurus()
    {
        return $this->source_thesaurus;
    }

    /**
     * @param Thesaurus $source_thesaurus
     */
    public function setSourceThesaurus($source_thesaurus)
    {
        $this->source_thesaurus = $source_thesaurus;
    }

    /**
     * @return Thesaurus
     */
    public function getCompletenessThesaurus()
    {
        return $this->completeness_thesaurus;
    }

    /**
     * @param Thesaurus $completeness_thesaurus
     */
    public function setCompletenessThesaurus($completeness_thesaurus)
    {
        $this->completeness_thesaurus = $completeness_thesaurus;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompletOptions()
    {
        return $this->complet_options;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $complet_options
     */
    public function setCompletOptions($complet_options)
    {
        $this->complet_options = $complet_options;
    }


    /**
     * @return Thesaurus
     */
    public function getPerformanceThesaurus()
    {
        return $this->performance_thesaurus;
    }

    /**
     * @param Thesaurus $performance_thesaurus
     */
    public function setPerformanceThesaurus($performance_thesaurus)
    {
        $this->performance_thesaurus = $performance_thesaurus;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFigurants()
    {
        return $this->figurants;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $figurants
     */
    public function setFigurants($figurants)
    {
        $this->figurants = $figurants;
    }

    /**
     * @return Thesaurus
     */
    public function getSpectatorsThesaurus()
    {
        return $this->spectators_thesaurus;
    }

    /**
     * @param Thesaurus $spectators_thesaurus
     */
    public function setSpectatorsThesaurus($spectators_thesaurus)
    {
        $this->spectators_thesaurus = $spectators_thesaurus;
    }

    /**
     * @return Thesaurus
     */
    public function getDiegeticThesaurus()
    {
        return $this->diegetic_thesaurus;
    }

    /**
     * @param Thesaurus $diegetic_thesaurus
     */
    public function setDiegeticThesaurus($diegetic_thesaurus)
    {
        $this->diegetic_thesaurus = $diegetic_thesaurus;
    }

    /**
     * @return Thesaurus
     */
    public function getMusicianThesaurus()
    {
        return $this->musician_thesaurus;
    }

    /**
     * @param Thesaurus $musician_thesaurus
     */
    public function setMusicianThesaurus($musician_thesaurus)
    {
        $this->musician_thesaurus = $musician_thesaurus;
    }

    /**
     * @return mixed
     */
    public function getQuotationText()
    {
        return $this->quotation_text;
    }

    /**
     * @param mixed $quotation_text
     */
    public function setQuotationText($quotation_text)
    {
        $this->quotation_text = $quotation_text;
    }

    /**
     * @return Thesaurus
     */
    public function getExoticismThesaurus()
    {
        return $this->exoticism_thesaurus;
    }

    /**
     * @param Thesaurus $exoticism_thesaurus
     */
    public function setExoticismThesaurus($exoticism_thesaurus)
    {
        $this->exoticism_thesaurus = $exoticism_thesaurus;
    }

    /**
     * @return Thesaurus
     */
    public function getDancemble()
    {
        return $this->dancemble;
    }

    /**
     * @param Thesaurus $dancemble
     */
    public function setDancemble($dancemble)
    {
        $this->dancemble = $dancemble;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChoregraphers()
    {
        return $this->choregraphers;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $choregraphers
     */
    public function setChoregraphers($choregraphers)
    {
        $this->choregraphers = $choregraphers;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArrangers()
    {
        return $this->arrangers;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $arrangers
     */
    public function setArrangers($arrangers)
    {
        $this->arrangers = $arrangers;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $director
     */
    public function setDirector($director)
    {
        $this->director = $director;
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
     * @return Thesaurus
     */
    public function getGeneralLocalisation()
    {
        return $this->general_localisation;
    }

    /**
     * @param Thesaurus $general_localisation
     */
    public function setGeneralLocalisation($general_localisation)
    {
        $this->general_localisation = $general_localisation;
    }

    /**
     * @return Thesaurus
     */
    public function getDiegeticPlaceThesaurus()
    {
        return $this->diegetic_place_thesaurus;
    }

    /**
     * @param Thesaurus $diegetic_place_thesaurus
     */
    public function setDiegeticPlaceThesaurus($diegetic_place_thesaurus)
    {
        $this->diegetic_place_thesaurus = $diegetic_place_thesaurus;
    }

    /**
     * @return Thesaurus
     */
    public function getImaginary()
    {
        return $this->imaginary;
    }

    /**
     * @param Thesaurus $imaginary
     */
    public function setImaginary($imaginary)
    {
        $this->imaginary = $imaginary;
    }

    /**
     * @return Thesaurus
     */
    public function getGeneralMood()
    {
        return $this->general_mood;
    }

    /**
     * @param Thesaurus $general_mood
     */
    public function setGeneralMood($general_mood)
    {
        $this->general_mood = $general_mood;
    }

    /**
     * @return Thesaurus
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param Thesaurus $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return Thesaurus
     */
    public function getTempoThesaurus()
    {
        return $this->tempo_thesaurus;
    }

    /**
     * @param Thesaurus $tempo_thesaurus
     */
    public function setTempoThesaurus($tempo_thesaurus)
    {
        $this->tempo_thesaurus = $tempo_thesaurus;
    }


    /**
     * @return Thesaurus
     */
    public function getQuotationThesaurus()
    {
        return $this->quotation_thesaurus;
    }

    /**
     * @param Thesaurus $quotation_thesaurus
     */
    public function setQuotationThesaurus($quotation_thesaurus)
    {
        $this->quotation_thesaurus = $quotation_thesaurus;
    }

    /**
     * @return mixed
     */
    public function getCompleteTitle()
    {
        return $this->completeTitle;
    }

    /**
     * @param mixed $completeTitle
     */
    public function setCompleteTitle($completeTitle)
    {
        $this->completeTitle = $completeTitle;
    }

    /**
     * @return mixed
     */
    public function getCompleteTc()
    {
        return $this->completeTc;
    }

    /**
     * @param mixed $completeTc
     */
    public function setCompleteTc($completeTc)
    {
        $this->completeTc = $completeTc;
    }

    /**
     * @return mixed
     */
    public function getCompleteStructure()
    {
        return $this->completeStructure;
    }

    /**
     * @param mixed $completeStructure
     */
    public function setCompleteStructure($completeStructure)
    {
        $this->completeStructure = $completeStructure;
    }

    /**
     * @return mixed
     */
    public function getCompleteShots()
    {
        return $this->completeShots;
    }

    /**
     * @param mixed $completeShots
     */
    public function setCompleteShots($completeShots)
    {
        $this->completeShots = $completeShots;
    }

    /**
     * @return mixed
     */
    public function getCompletePerformance()
    {
        return $this->completePerformance;
    }

    /**
     * @param mixed $completePerformance
     */
    public function setCompletePerformance($completePerformance)
    {
        $this->completePerformance = $completePerformance;
    }

    /**
     * @return mixed
     */
    public function getCompleteBackstage()
    {
        return $this->completeBackstage;
    }

    /**
     * @param mixed $completeBackstage
     */
    public function setCompleteBackstage($completeBackstage)
    {
        $this->completeBackstage = $completeBackstage;
    }

    /**
     * @return mixed
     */
    public function getCompleteTheme()
    {
        return $this->completeTheme;
    }

    /**
     * @param mixed $completeTheme
     */
    public function setCompleteTheme($completeTheme)
    {
        $this->completeTheme = $completeTheme;
    }

    /**
     * @return mixed
     */
    public function getCompleteMood()
    {
        return $this->completeMood;
    }

    /**
     * @param mixed $completeMood
     */
    public function setCompleteMood($completeMood)
    {
        $this->completeMood = $completeMood;
    }

    /**
     * @return mixed
     */
    public function getCompleteDance()
    {
        return $this->completeDance;
    }

    /**
     * @param mixed $completeDance
     */
    public function setCompleteDance($completeDance)
    {
        $this->completeDance = $completeDance;
    }

    /**
     * @return mixed
     */
    public function getCompleteMusic()
    {
        return $this->completeMusic;
    }

    /**
     * @param mixed $completeMusic
     */
    public function setCompleteMusic($completeMusic)
    {
        $this->completeMusic = $completeMusic;
    }

    /**
     * @return mixed
     */
    public function getCompleteDirector()
    {
        return $this->completeDirector;
    }

    /**
     * @param mixed $completeDirector
     */
    public function setCompleteDirector($completeDirector)
    {
        $this->completeDirector = $completeDirector;
    }

    /**
     * @return mixed
     */
    public function getCompleteCost()
    {
        return $this->completeCost;
    }

    /**
     * @param mixed $completeCost
     */
    public function setCompleteCost($completeCost)
    {
        $this->completeCost = $completeCost;
    }

    /**
     * @return mixed
     */
    public function getCompleteReference()
    {
        return $this->completeReference;
    }

    /**
     * @param mixed $completeReference
     */
    public function setCompleteReference($completeReference)
    {
        $this->completeReference = $completeReference;
    }

    /**
     * @return Thesaurus
     */
    public function getMusicalThesaurus()
    {
        return $this->musical_thesaurus;
    }

    /**
     * @param Thesaurus $musical_thesaurus
     */
    public function setMusicalThesaurus($musical_thesaurus)
    {
        $this->musical_thesaurus = $musical_thesaurus;
    }

    /**
     * @return mixed
     */
    public function getCommentTitle()
    {
        return $this->commentTitle;
    }

    /**
     * @param mixed $commentTitle
     */
    public function setCommentTitle($commentTitle)
    {
        $this->commentTitle = $commentTitle;
    }

    /**
     * @return mixed
     */
    public function getCommentTc()
    {
        return $this->commentTc;
    }

    /**
     * @param mixed $commentTc
     */
    public function setCommentTc($commentTc)
    {
        $this->commentTc = $commentTc;
    }

    /**
     * @return mixed
     */
    public function getCommentStructure()
    {
        return $this->commentStructure;
    }

    /**
     * @param mixed $commentStructure
     */
    public function setCommentStructure($commentStructure)
    {
        $this->commentStructure = $commentStructure;
    }

    /**
     * @return mixed
     */
    public function getCommentShots()
    {
        return $this->commentShots;
    }

    /**
     * @param mixed $commentShots
     */
    public function setCommentShots($commentShots)
    {
        $this->commentShots = $commentShots;
    }

    /**
     * @return mixed
     */
    public function getCommentPerformance()
    {
        return $this->commentPerformance;
    }

    /**
     * @param mixed $commentPerformance
     */
    public function setCommentPerformance($commentPerformance)
    {
        $this->commentPerformance = $commentPerformance;
    }

    /**
     * @return mixed
     */
    public function getCommentTheme()
    {
        return $this->commentTheme;
    }

    /**
     * @param mixed $commentTheme
     */
    public function setCommentTheme($commentTheme)
    {
        $this->commentTheme = $commentTheme;
    }

    /**
     * @return mixed
     */
    public function getCommentMood()
    {
        return $this->commentMood;
    }

    /**
     * @param mixed $commentMood
     */
    public function setCommentMood($commentMood)
    {
        $this->commentMood = $commentMood;
    }

    /**
     * @return mixed
     */
    public function getCommentDance()
    {
        return $this->commentDance;
    }

    /**
     * @param mixed $commentDance
     */
    public function setCommentDance($commentDance)
    {
        $this->commentDance = $commentDance;
    }

    /**
     * @return mixed
     */
    public function getCommentMusic()
    {
        return $this->commentMusic;
    }

    /**
     * @param mixed $commentMusic
     */
    public function setCommentMusic($commentMusic)
    {
        $this->commentMusic = $commentMusic;
    }

    /**
     * @return mixed
     */
    public function getCommentDirector()
    {
        return $this->commentDirector;
    }

    /**
     * @param mixed $commentDirector
     */
    public function setCommentDirector($commentDirector)
    {
        $this->commentDirector = $commentDirector;
    }

    /**
     * @return mixed
     */
    public function getCommentBackstage()
    {
        return $this->commentBackstage;
    }

    /**
     * @param mixed $commentBackstage
     */
    public function setCommentBackstage($commentBackstage)
    {
        $this->commentBackstage = $commentBackstage;
    }

    /**
     * @return mixed
     */
    public function getCommentReference()
    {
        return $this->commentReference;
    }

    /**
     * @param mixed $commentReference
     */
    public function setCommentReference($commentReference)
    {
        $this->commentReference = $commentReference;
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

    /**
     * @return mixed
     */
    public function getCompleteAll()
    {
        return $this->completeAll;
    }

    /**
     * @param mixed $completeAll
     */
    public function setCompleteAll($completeAll)
    {
        $this->completeAll = $completeAll;
    }

    /**
     * @return ArrayCollection
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param ArrayCollection $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
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


    public function __toString()
    {
        return (string) $this->getTitle();
    }

    public function  allThesaurus(){

        $allThesaurus =  $this->musical_thesaurus;

        return $allThesaurus;
    }




}
