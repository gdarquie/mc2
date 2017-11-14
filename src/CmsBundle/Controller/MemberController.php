<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("/member")
 */
class MemberController extends Controller
{

    /**
     * @Route("/numbers", name="numbers")
     */
    public function AllNumbersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT n FROM AppBundle:Number n')->setMaxResults(5000);
        $numbers = $query->getResult();

        return $this->render('CmsBundle:Member:items.html.twig', array(
            'items' => $numbers,
            'type' => 'number'
        ));
    }

    /**
     * @Route("/films", name="films")
     */
    public function AllFilmsAction()
    {
        $em = $this->getDoctrine()->getManager();
//        $films = $em->getRepository('AppBundle:Film')->findAll();
        $query = $em->createQuery('SELECT n FROM AppBundle:Film n')->setMaxResults(5000);
        $films = $query->getResult();

        return $this->render('CmsBundle:Member:items.html.twig', array(
            'items' => $films,
            'type' => 'film'
        ));
        
    }

    /**
     * @Route("/stageshows", name="stageshows")
     */
    public function AllStageshowsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT n FROM AppBundle:Stageshow n')->setMaxResults(5000);
        $numbers = $query->getResult();

        return $this->render('CmsBundle:Member:items.html.twig', array(
            'items' => $numbers,
            'type' => 'stageshow'
        ));
    }

    /**
     * @Route("/songs", name="songs")
     */
    public function AllSongsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT n FROM AppBundle:Song n')->setMaxResults(5000);
        $numbers = $query->getResult();

        return $this->render('CmsBundle:Member:items.html.twig', array(
            'items' => $numbers,
            'type' => 'song'
        ));

    }

    /**
     * @Route("/songs/special", name = "songs_special")
     */
    public function showAllAction(){

        $em = $this->getDoctrine()->getManager();

        //All songs
        $query = $em->createQuery("SELECT s.title as title, s.date as date, s.songId as songId, COUNT(n.id) as nb,COUNT(DIStiNCT(f.filmId)) as nbFilms FROM AppBundle:Song s LEFT JOIN s.number n JOIN n.film f GROUP BY s.songId ORDER BY nb DESC");
//        $query->setParameter('person', $name );
        $songs = $query->getResult();

        $min = 2;

//        List of songId used by at least $max_number numbers
        $query = $em->createQuery("SELECT s.songId as songId FROM AppBundle:Song s JOIN s.number n GROUP BY s.songId HAVING COUNT(n.id)  >= :min ");
        $query->setParameter('min', $min );
        $songWithMultipleNumbers = $query->getResult();

//        List of songId used by at least $min distinct films
        $query = $em->createQuery("SELECT s.songId as songId FROM AppBundle:Song s JOIN s.number n JOIN n.film f GROUP BY s.songId HAVING COUNT(DISTINCT(f.filmId))  >= :min ");
        $query->setParameter('min', $min );
        $songWithMultipleFilms = $query->getResult();

        //List of all films with the songs used in two different films [not used by Marion]
        $query = $em->createQuery("SELECT f.filmId FROM AppBundle:Number n JOIN n.film f JOIN n.song s WHERE s.songId IN(:songs)");
        $query->setParameter('songs', $songWithMultipleFilms );
        $listFilmsWith2Songs = $query->getResult();

        //Titles of all films with the songs used in two different films [not used by Marion, check with her]
        $query = $em->createQuery("SELECT f.title FROM AppBundle:Number n JOIN n.film f JOIN n.song s WHERE s.songId IN(:songs)");
        $query->setParameter('songs', $songWithMultipleFilms );
        $titlesFilmsWith2Songs = $query->getResult();

        //Films with popular songs with performance_thesaurus = "intrumental+dance" OR 186
        $query = $em->createQuery("SELECT DISTINCT(f.filmId) as filmId FROM AppBundle:Number n JOIN n.film f JOIN n.song s WHERE s.songId IN(:songs) AND (n.performance_thesaurus = :perf1 OR n.performance_thesaurus = :perf2)");
        $query->setParameter('songs', $songWithMultipleFilms );
        $query->setParameter('perf1', "intrumental+dance" );
        $query->setParameter('perf2', 186 );
        $titlesFilmsWith2Songs = $query->getResult();

        return $this->render('CmsBundle:Member:song.html.twig',array(
            'songs' => $songs,
            'songWithMultipleNumbers' => $songWithMultipleNumbers,
            'songWithMultipleFilms' => $songWithMultipleFilms,
            'listFilmsWith2Songs' => $listFilmsWith2Songs,
            'titlesFilmsWith2Songs' => $titlesFilmsWith2Songs,
            'min' => $min
        ));
    }


    /**
     * @Route("/stagenumbers", name="stagenumbers")
     */
    public function AllStagenumbersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT n FROM AppBundle:Stagenumber n')->setMaxResults(5000);
        $numbers = $query->getResult();

        return $this->render('CmsBundle:Member:items.html.twig', array(
            'items' => $numbers,
            'type' => 'stagenumber'
        ));
    }


    /**
     * @Route("/persons", name="persons")
     */
    public function AllPersonsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT n FROM AppBundle:Person n')->setMaxResults(5000);
        $numbers = $query->getResult();

        return $this->render('CmsBundle:Member:items.html.twig', array(
            'items' => $numbers,
            'type' => 'person'
        ));
    }
    /**
     * @Route("/", name="editor")
     */
    public function userAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getId();

        //all films
        $films = $em->getRepository('AppBundle:Film')->findAll();

        //all numbers
        $numbers = $em->getRepository('AppBundle:Number')->findAll();

        //Films with number
        $query = $em->createQuery(
            'SELECT f.filmId as filmId, f.title as title  FROM AppBundle:Film f WHERE f.filmId IN (SELECT IDENTITY(n.film) FROM AppBundle:Number n WHERE n.film != 0)'
        );
        $filmsWithNumber = $query->getResult();

        //All Persons
        $persons = $em->getRepository('AppBundle:Person')->findAll();

        // ------------
        //Help numbers
        // ------------

        //List of films where help is need -- 2 is for help
        $query = $em->createQuery('SELECT n FROM AppBundle:Number n WHERE n.completeTitle = 2 OR n.completeTc = 2 OR n.completeStructure = 2 OR n.completeShots = 2 OR n.completeBackstage = 2 OR n.completePerformance = 2 OR n.completeTheme = 2 OR n.completeMood = 2 OR n.completeDance = 2 OR n.completeMusic = 2 OR n.completeDirector = 2 OR n.completeCost = 2 ');
        //OR n.completeReference = 2
        $help = $query->getResult();

        //List of help for title
        $query = $em->createQuery('SELECT n FROM AppBundle:Number n WHERE n.completeTitle = 2');
        $help_title = $query->getResult();

        //List of help for tc
        $query = $em->createQuery('SELECT n FROM AppBundle:Number n WHERE n.completeTc = 2');
        $help_tc = $query->getResult();

        //-----------------
        //My items
        //-----------------

        //My last Numbers (ajouter des options et ue pagination)
        $query = $em->createQuery('SELECT n FROM AppBundle:Number n JOIN n.editors e JOIN n.film f WHERE e.id = :user ORDER BY n.last_update ');
        $query->setParameter('user', $user );
        $myNumbers = $query->getResult();

        //My films
        $query = $em->createQuery('SELECT DISTINCT(f.filmId) as filmId, f.title as title, f.released as released FROM AppBundle:Number n JOIN n.editors e JOIN n.film f WHERE e.id = :user GROUP BY n.film ORDER BY f.title')
            ->setParameter('user', $user)
        ;
        $myFilms = $query->getResult();

        $query = $em->createQuery('SELECT n FROM AppBundle:Song n JOIN n.editors e WHERE e.id = :user');
        $query->setParameter('user', $user );
        $mySongs = $query->getResult();


        $query = $em->createQuery('SELECT n FROM AppBundle:Person n JOIN n.editors e WHERE e.id = :user');
        $query->setParameter('user', $user );
        $myPersons = $query->getResult();

        //-----------------
        //Last changes
        //-----------------

        //Last Numbers changed (limiter à la personne et ajouter des options et ue pagination)
        $query = $em->createQuery('SELECT n FROM AppBundle:Number n JOIN n.editors e WHERE e.id = :user ORDER BY n.last_update ')->setMaxResults(50);
        $query->setParameter('user', $user );
        $myLastNumbers = $query->getResult();

        //Last Films changed (limiter à la personne et ajouter des options et ue pagination)
        $query = $em->createQuery('SELECT f.filmId as id, f.title as title, f.released as released FROM AppBundle:Number n JOIN n.editors e JOIN n.film f WHERE e.id = :user GROUP BY f.filmId ORDER BY n.last_update ')->setMaxResults(50);
        $query->setParameter('user', $user );
        $mylastFilms = $query->getResult();


        return $this->render('CmsBundle:Member:index.html.twig', array(
            'films' => $films,
            'numbers' => $numbers,
            'filmsWithNumber' => $filmsWithNumber,
            'persons' => $persons,
            'help' => $help,
            'help_title' => $help_title,
            'help_tc' => $help_tc,
            'myLastNumbers' => $myLastNumbers,
            'myLastFilms' => $mylastFilms,
            'myFilms' => $myFilms,
            'myNumbers' => $myNumbers,
            'mySongs' => $mySongs,
            'myPersons' => $myPersons
        ));
    }
}
