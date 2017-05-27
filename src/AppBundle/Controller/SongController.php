<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SongController extends Controller
{
    /**
     * @Route("/songs", name = "songs")
     */
    public function showAllAction(){

        $em = $this->getDoctrine()->getManager();

        //All songs
        $query = $em->createQuery("SELECT s.title as title, s.date as date, s.songId as songId, COUNT(n.numberId) as nb,COUNT(DIStiNCT(f.filmId)) as nbFilms FROM AppBundle:Song s LEFT JOIN s.number n JOIN n.film f GROUP BY s.songId ORDER BY nb DESC");
//        $query->setParameter('person', $name );
        $songs = $query->getResult();

        $min = 2;

//        List of songId used by at least $max_number numbers
        $query = $em->createQuery("SELECT s.songId as songId FROM AppBundle:Song s JOIN s.number n GROUP BY s.songId HAVING COUNT(n.numberId)  >= :min ");
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

        //Films with popular songs with performance = "intrumental+dance" OR "song+dance"
        $query = $em->createQuery("SELECT DISTINCT(f.filmId) as filmId FROM AppBundle:Number n JOIN n.film f JOIN n.song s WHERE s.songId IN(:songs) AND (n.performance = :perf1 OR n.performance = :perf2)");
        $query->setParameter('songs', $songWithMultipleFilms );
        $query->setParameter('perf1', "intrumental+dance" );
        $query->setParameter('perf2', "song+dance" );
        $titlesFilmsWith2Songs = $query->getResult();

        return $this->render('AppBundle:song:index.html.twig',array(
            'songs' => $songs,
            'songWithMultipleNumbers' => $songWithMultipleNumbers,
            'songWithMultipleFilms' => $songWithMultipleFilms,
            'listFilmsWith2Songs' => $listFilmsWith2Songs,
            'titlesFilmsWith2Songs' => $titlesFilmsWith2Songs,
            'min' => $min
        ));
    }


    //For Marion Presentation in MAMI 2017
    /**
     * @Route("/songs/music", name = "songs_music")
     */
    public function musicAction(){

        $em = $this->getDoctrine()->getManager();

        //All songs
        $query = $em->createQuery("SELECT s.title as title, s.date as date, s.songId as songId, COUNT(n.numberId) as nb,COUNT(DIStiNCT(f.filmId)) as nbFilms FROM AppBundle:Song s JOIN s.number n JOIN n.film f GROUP BY s.songId ORDER BY nb DESC");
//        $query->setParameter('person', $name );
        $songs = $query->getResult();


        $min = 2;

//        List of songId used by at least $max_number numbers
        $query = $em->createQuery("SELECT s.songId as songId FROM AppBundle:Song s JOIN s.number n GROUP BY s.songId HAVING COUNT(n.numberId)  >= :min ");
        $query->setParameter('min', $min );
        $songWithMultipleNumbers = $query->getResult();

//        List of songId used by at least $min distinct films
        $query = $em->createQuery("SELECT s.songId as songId FROM AppBundle:Song s JOIN s.number n JOIN n.film f GROUP BY s.songId HAVING COUNT(DISTINCT(f.filmId))  >= :min ");
        $query->setParameter('min', $min );
        $songIdWithMultipleFilms = $query->getResult();

        $query = $em->createQuery("SELECT s.songId as songId, s.title as title, f.title as film, n.title as number, COUNT(DISTINCT(f.filmId)) as nbFilm, COUNT(DISTINCT(n.numberId)) as nbNumber FROM AppBundle:Song s JOIN s.number n JOIN n.film f GROUP BY s.songId HAVING COUNT(DISTINCT(f.filmId))  >= :min ");
        $query->setParameter('min', $min );
        $songWithMultipleFilms = $query->getResult();

        //List of all films with the songs used in two different films [not used by Marion]
        $query = $em->createQuery("SELECT DISTINCT(f.filmId) FROM AppBundle:Number n JOIN n.film f JOIN n.song s WHERE s.songId IN(:songs)");
        $query->setParameter('songs', $songIdWithMultipleFilms );
        $listFilmsWith2Songs = $query->getResult();

        //Titles of all films with the songs used in two different films [not used by Marion, check with her]
        $query = $em->createQuery("SELECT f.title as title, f.filmId as filmId FROM AppBundle:Number n JOIN n.film f JOIN n.song s WHERE s.songId IN(:songs) GROUP BY f.filmId");
        $query->setParameter('songs', $songIdWithMultipleFilms );
        $titlesFilmsWith2Songs = $query->getResult();

        //Films with popular songs with performance = "intrumental+dance" OR "song+dance"
        $query = $em->createQuery("SELECT f.filmId as filmId, f.title as title, COUNT(DISTINCT(n.numberId)) as nbNumber, COUNT(DISTINCT(f.filmId)) as nbFilm FROM AppBundle:Number n JOIN n.film f JOIN n.song s  WHERE (s.songId IN(:songs) AND (n.performance = :perf1 OR n.performance = :perf2)) GROUP BY f.filmId");
        $query->setParameter('songs', $songIdWithMultipleFilms );
        $query->setParameter('perf1', "intrumental+dance" );
        $query->setParameter('perf2', "song+dance" );
        $listeFilmsWith2SongsAndDance = $query->getResult();

        //Dance films
        $query = $em->createQuery("SELECT DISTINCT(f.filmId) as filmId FROM AppBundle:Number n JOIN n.film f JOIN n.song s WHERE n.performance = :perf1 OR n.performance = :perf2");
        $query->setParameter('perf1', "intrumental+dance" );
        $query->setParameter('perf2', "song+dance" );
        $danceFilms = $query->getResult();

        //Dance number
        $query = $em->createQuery("SELECT DISTINCT(n.numberId) as numberId FROM AppBundle:Number n JOIN n.film f JOIN n.song s WHERE n.performance = :perf1 OR n.performance = :perf2");
        $query->setParameter('perf1', "intrumental+dance" );
        $query->setParameter('perf2', "song+dance" );
        $danceNumbers = $query->getResult();

        //Films with popular songs with performance = "intrumental+dance" OR "song+dance"
        $query = $em->createQuery("SELECT s.songId as songId, s.title as title, COUNT(DISTINCT(n.numberId)) as nbNumber, COUNT(DISTINCT(f.filmId)) as nbFilm FROM AppBundle:Number n JOIN n.film f JOIN n.song s  WHERE (s.songId IN(:songs) AND (n.performance = :perf1 OR n.performance = :perf2)) GROUP BY s.songId");
        $query->setParameter('songs', $songIdWithMultipleFilms );
        $query->setParameter('perf1', "intrumental+dance" );
        $query->setParameter('perf2', "song+dance" );
        $listeSongsWithFilms2SongsAndDance = $query->getResult();



        //Je cherche une liste de films : cette liste sera dans listFilmsWith2SongAndDance mais je ne veux que les films liés à des songs qui sont utilisés

        //Liste de tous les films qui contiennent qui ne contiennent pas de danse

        return $this->render('AppBundle:song:music.html.twig',array(
            'songs' => $songs,
            'songWithMultipleNumbers' => $songWithMultipleNumbers,
            'songWithMultipleFilms' => $songWithMultipleFilms,
            'titlesFilmsWith2Songs' => $titlesFilmsWith2Songs,
            'listFilmsWith2Songs' => $listFilmsWith2Songs,
            'titlesFilmsWith2Songs' => $titlesFilmsWith2Songs,
            'listeFilmsWith2SongsAndDance' => $listeFilmsWith2SongsAndDance,
            'songIdWithMultipleFilms' => $songIdWithMultipleFilms,
            'danceFilms' => $danceFilms,
            'danceNumbers' => $danceNumbers,
            'listeSongsWithFilms2SongsAndDance' => $listeSongsWithFilms2SongsAndDance,
            'min' => $min
        ));
    }


    /**
     * @Route("song/id/{songId}", name="song")
     */
    public function songAction($songId){

        $em = $this->getDoctrine()->getManager();
        $song = $em->getRepository('AppBundle:Song')->findOneBySongId($songId);

        $query = $em->createQuery("SELECT DISTINCT(f.title) as title, f.filmId as filmId, f.idImdb as imdb FROM AppBundle:Song s LEFT JOIN s.number n JOIN n.film f WHERE s.songId = :songId");
        $query->setParameter('songId', $songId );
        $films = $query->getResult();


        return $this->render('AppBundle:song:song.html.twig',array(
            'song' => $song,
            'films' => $films
        ));
    }



}
