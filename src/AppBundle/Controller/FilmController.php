<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Film;
use AppBundle\Form\FilmType;


class FilmController extends Controller
{


    /**
     * @Route("/film/id/{filmId}", name="film")
     */
    public function filmAction($filmId){

        $em = $this->getDoctrine()->getManager();
//        $film = $em->getRepository('AppBundle:Film')->findOneByFilmId($filmId);

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT f FROM AppBundle:Film f WHERE f.filmId = :film");
        $query->setParameter('film', $filmId);
        $film = $query->getSingleResult();

        //tous les numbers du film

        //            'SELECT  (n.id) as id, (n.title) as title, (n.film) as film, (n.beginTc) as beginTc, (n.endTc) as endTc, (n.length) as length, (t.title) as structure, (n.length)/(n.shots) as average, (n.cast) as cast, (n.shots) as shots FROM AppBundle:Number n LEFT JOIN n.structure as t  WHERE n.film = :film ORDER BY n.beginTc'

        $query = $em->createQuery(
            'SELECT  n FROM AppBundle:Number n  WHERE n.film = :film ORDER BY n.beginTc'
        );
        $query->setParameter('film', $film);
        $numbersOf1Film = $query->getResult();

        //moyenne des number pour le film
        $query = $em->createQuery(
            'SELECT SUM(f.length) / COUNT(f.title) as average FROM AppBundle:Number f WHERE f.film = :film'
        );
        $query->setParameter('film', $film);
        $numberAverageLength = $query->getResult();

        //moyenne des number pour tous les films
        $query = $em->createQuery(
            'SELECT SUM(f.length) / COUNT(f.title) as average FROM AppBundle:Number f'
        );
        $numbersAverageLength = $query->getResult();

        //addition de tous les numbers pour le film
        $query = $em->createQuery(
            'SELECT SUM(n.length) as total, (f.length) as length FROM AppBundle:Number n JOIN n.film f WHERE n.film = :film'
        );
        $query->setParameter('film', $film);
        $numberSumLength = $query->getResult();

        //persons linked to a movie
        $query = $em->createQuery(
            'SELECT a.personId as personId FROM AppBundle:FilmHasPerson a WHERE a.filmId = :film' //film has person
        ); //SELECT p.name FROM AppBundle:Person p WHERE p.personId IN ()
        $query->setParameter('film', $film);
        $persons1Film = $query->getResult();


        //All Persons
        $persons = $em->getRepository('AppBundle:Person')->findAll();

        //All Professions
        $professions = $em->getRepository('AppBundle:Profession')->findAll();

        //All Numbers
        $numbers = $em->getRepository('AppBundle:Number')->findAll();


        //faire une viz avec la chronologie des numbers

        //voir tous les numbers d'un film (lien pour modifier le number) + ajouter un number

        if (!$film) {

            return $this->render('404.html.twig', array(
                'message' => 'No Film found for id '.$filmId
            ));
        }

        return $this->render('AppBundle:film:film.html.twig', array(
            'film' => $film,
            'numbers' => $numbers,
            'numbersOf1Film' => $numbersOf1Film,
            'numberAverageLength' => $numberAverageLength,
            'numbersAverageLength' => $numbersAverageLength,
            'numberSumLength' => $numberSumLength,
            'persons' => $persons,
            'professions' => $professions,
            'persons1Film' => $persons1Film,
        ));


    }


    /**
     * @Route("films/avgMovie", name = "avgMovie")
     */
    public function avgMovie() {

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT COUNT(f) as total FROM AppBundle:Film f");
        $totalFilms = $query->getSingleResult();

        $query = $em->createQuery("SELECT COUNT(f.filmId) as total FROM AppBundle:Film f WHERE f.filmId IN (SELECT IDENTITY(n.film) FROM AppBundle:Number n WHERE n.film != 0)");
        $filmsWithNumber = $query->getSingleResult();

        $query = $em->createQuery("SELECT f.filmId as filmID FROM AppBundle:Film f WHERE f.filmId IN (SELECT IDENTITY(n.film) FROM AppBundle:Number n WHERE n.film != 0) ORDER BY f.filmId");
        $listefilmsWithNumber = $query->getResult();

        $query = $em->createQuery("SELECT COUNT(n) as nbNumbers FROM AppBundle:Number n GROUP BY n.film ORDER BY n.film");
        $listeNbNumbers = $query->getResult();

        $query = $em->createQuery("SELECT f.title as titleFilm FROM AppBundle:Film f WHERE f.filmId IN (:liste) ORDER BY f.filmId");
        $query->setParameter('liste',$listefilmsWithNumber);
        $listetitleFilmWithNumbers = $query->getResult();

        $sumNumbers = 0;
        $countNumbers = 0;
        foreach ($listeNbNumbers as $key => $item) {
            $sumNumbers += (int)$listeNbNumbers[$key]['nbNumbers'];
            $countNumbers++;
        }

        if(count($listeNbNumbers) == count($listetitleFilmWithNumbers)) {

            $NameFilmWithCountNumbers = [];
            for ($i = 0; $i < count($listeNbNumbers); $i++) {
                array_push($NameFilmWithCountNumbers, array("NameFilm" => $listetitleFilmWithNumbers[$i]['titleFilm'], "NbOfNumbers" => $listeNbNumbers[$i]['nbNumbers']));
            }
        }

        $NbFilm = 0;
        foreach ($NameFilmWithCountNumbers as $key => $item) {
            if($NameFilmWithCountNumbers[$key]['NbOfNumbers'] > round(($sumNumbers/$countNumbers),0)) {
                $NbFilm++;
            }
        }

        return $this->render('AppBundle:film:avg.html.twig',array(
            'totalFilms' => $totalFilms,
            'filmsWithNumber' => $filmsWithNumber,
            'sumNumbers' => $sumNumbers,
            'countNumbers' => $countNumbers,
            'NameFilmWithCountNumbers' => $NameFilmWithCountNumbers,
            'NbFilm' => $NbFilm
        ));
    }


}
