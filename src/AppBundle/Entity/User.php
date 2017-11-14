<?php
 // src/AppBundle/Entity/User.php
 
 namespace AppBundle\Entity;
 
 use FOS\UserBundle\Model\User as BaseUser;
 use Doctrine\ORM\Mapping as ORM;
 
 /**
  * @ORM\Entity
  * @ORM\Table(name="fos_user")
  */
 class User extends BaseUser
 {
     /**
      * @ORM\Id
      * @ORM\Column(type="integer")
      * @ORM\GeneratedValue(strategy="AUTO")
      */
     protected $id;

     /**
      * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Number", mappedBy="editors")
      */
     private $numberEditor;

     /**
      * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Film", mappedBy="editors")
      */
     private $filmEditor;

     /**
      * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Song", mappedBy="editors")
      */
     private $songEditor;

     /**
      * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus", mappedBy="editors")
      */
     private $thesaurusEditor;

     /**
      * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stagenumber", mappedBy="editors")
      */
     private $stagenumberEditor;

     /**
      * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Stageshow", mappedBy="editors")
      */
     private $stageshowEditor;

     /**
      * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Person", mappedBy="editors")
      */
     private $personEditor;

     /**
      * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Code", mappedBy="editors")
      */
     private $codeEditor;

     /**
      * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Censorship", mappedBy="editors")
      */
     private $censorshipEditor;



     public function __construct()
     {
         parent::__construct();
         // your own logic
     }

     /**
      * @return mixed
      */
     public function getNumberEditor()
     {
         return $this->numberEditor;
     }

     /**
      * @param mixed $numberEditor
      */
     public function setNumberEditor($numberEditor)
     {
         $this->numberEditor = $numberEditor;
     }

     /**
      * @return mixed
      */
     public function getFilmEditor()
     {
         return $this->filmEditor;
     }

     /**
      * @param mixed $filmEditor
      */
     public function setFilmEditor($filmEditor)
     {
         $this->filmEditor = $filmEditor;
     }

     /**
      * @return mixed
      */
     public function getSongEditor()
     {
         return $this->songEditor;
     }

     /**
      * @param mixed $songEditor
      */
     public function setSongEditor($songEditor)
     {
         $this->songEditor = $songEditor;
     }

     /**
      * @return mixed
      */
     public function getThesaurusEditor()
     {
         return $this->thesaurusEditor;
     }

     /**
      * @param mixed $thesaurusEditor
      */
     public function setThesaurusEditor($thesaurusEditor)
     {
         $this->thesaurusEditor = $thesaurusEditor;
     }

     /**
      * @return mixed
      */
     public function getStagenumberEditor()
     {
         return $this->stagenumberEditor;
     }

     /**
      * @param mixed $stagenumberEditor
      */
     public function setStagenumberEditor($stagenumberEditor)
     {
         $this->stagenumberEditor = $stagenumberEditor;
     }

     /**
      * @return mixed
      */
     public function getStageshowEditor()
     {
         return $this->stageshowEditor;
     }

     /**
      * @param mixed $stageshowEditor
      */
     public function setStageshowEditor($stageshowEditor)
     {
         $this->stageshowEditor = $stageshowEditor;
     }

     /**
      * @return mixed
      */
     public function getPersonEditor()
     {
         return $this->personEditor;
     }

     /**
      * @param mixed $personEditor
      */
     public function setPersonEditor($personEditor)
     {
         $this->personEditor = $personEditor;
     }

     /**
      * @return mixed
      */
     public function getCodeEditor()
     {
         return $this->codeEditor;
     }

     /**
      * @param mixed $codeEditor
      */
     public function setCodeEditor($codeEditor)
     {
         $this->codeEditor = $codeEditor;
     }

     /**
      * @return mixed
      */
     public function getCensorshipEditor()
     {
         return $this->censorshipEditor;
     }

     /**
      * @param mixed $censorshipEditor
      */
     public function setCensorshipEditor($censorshipEditor)
     {
         $this->censorshipEditor = $censorshipEditor;
     }



 }