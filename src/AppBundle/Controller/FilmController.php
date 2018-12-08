<?php

namespace AppBundle\Controller;

use AppBundle\Component\FilmHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FilmController extends BaseController
{
    const FILM = 'film';

    /**
     * @Route("/film/id/{filmId}", name="film")
     */
    public function filmAction($filmId){

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT f FROM AppBundle:Film f WHERE f.filmId = :film");
        $query->setParameter('film', $filmId);
        $film = $query->getSingleResult();

        $payload = $this->getHandler(FilmController::FILM)->getFilmPayload($filmId);

        //change with API //not secure at all!!! use pagination

        //All Persons
        $persons = $em->getRepository('AppBundle:Person')->findAll();

        //All Professions
        $professions = $em->getRepository('AppBundle:Profession')->findAll();

        //All Numbers
        $numbers = $em->getRepository('AppBundle:Number')->findAll();


        if (!$film) {

            return $this->render('404.html.twig', array(
                'message' => 'No Film found for id '.$filmId
            ));
        }

        return $this->render('AppBundle:film:film.html.twig', array(
            'film' => $film,
            'numbers' => $numbers,
            'numbersOf1Film' => $payload['numbersOf1Film'],
            'numberAverageLength' => $payload['numberAverageLength'],
            'numbersAverageLength' => $payload['numbersAverageLength'],
            'numberSumLength' => $payload['numberSumLength'],
            'persons1Film' => $payload['persons1Film'],
            'persons' => $persons,
            'professions' => $professions,
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
