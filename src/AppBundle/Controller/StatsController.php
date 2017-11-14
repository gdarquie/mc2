<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\ResultSetMapping;

class StatsController extends Controller
{
//Stats (créer un controller spécial???)
    /**
     * @Route("/stats", name="stats")
     */
    public function statsAction()
    {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p.released as year, COUNT (DISTINCT(p.title)) as nb
            FROM AppBundle:Film p GROUP BY p.released ' //ORDER BY nb DESC
        );
        $nbFilmsByYear = $query->getResult();

        //Nombre de number par année
//        $query = $em->createQuery(
//            'SELECT f.released, COUNT(n.title) as nb, COUNT(DISTINCT(f.title)) as nbFilms FROM AppBundle:Film f LEFT JOIN f.numbers n WHERE f.released > 0 GROUP BY f.released   ORDER BY f.released ASC'
//        );
        $query = $em->createQuery(
            'SELECT f.released as year, COUNT(DISTINCT(n.title)) as nb FROM AppBundle:Number n JOIN n.film f GROUP BY f.released'
        );
        $nbNumbersByYear = $query->getResult();


        //Nombre de sources de number par année
        $query = $em->createQuery(
            'SELECT f.released as year, COUNT(DISTINCT(n.title)) as nb FROM AppBundle:Number n JOIN n.film f WHERE n.source = :source GROUP BY f.released '
        );
        $query->setParameter('source', 'borrowed from the musical repertoire');
        $source1ByYear = $query->getResult();

        //Répartition des socialPlaces pour les numbers (à reprendre avec la bonne requête)
        $query = $em->createQuery(
            'SELECT f.released as year, COUNT(DISTINCT(n.title)) as nb FROM AppBundle:Number n JOIN n.film f GROUP BY f.released'
        );
        $nbSocialPlaceByNumber =$query->getResult();


        //tous les films qui ont au moins un number
        $query = $em->createQuery(
            'SELECT f.title as films FROM AppBundle:Film f WHERE f.filmId IN (SELECT IDENTITY(n.film) FROM AppBundle:Number n WHERE n.film != 0)'
        );
        $nbFilmsWithNumber = $query->getResult();

        //All movies
        $films = $em->getRepository('AppBundle:Film')->findAll();

        //Sélection de 10 films (à limiter à 10)
        $last10Films = $em->getRepository('AppBundle:Film')->findAll(); //mettre un set max Results à 10

        //Tous les numbers
        $numbers = $em->getRepository('AppBundle:Number')->findAll();

        //Total des durées de film
        $query = $em->createQuery(
            'SELECT SUM(f.length) as length FROM AppBundle:Film f'
        );
        $filmsLength = $query->getResult();

        //Moyenne des durées de film
        $query = $em->createQuery(
            'SELECT SUM(f.length) / COUNT(f.title) as average FROM AppBundle:Film f'
        );
        $filmsAverageLength = $query->getResult();

        //Le film le plus long
        $query = $em->createQuery(
            'SELECT f.title as title, f.length as length FROM AppBundle:Film f WHERE f.length = (SELECT MAX(m.length) FROM AppBundle:Film m WHERE m.length > 2700)'
        );
        $filmsMaxLength = $query->setMaxResults(1)->getResult();

        //film le plus court
        $query = $em->createQuery(
            'SELECT f.title as title, f.length as length FROM AppBundle:Film f WHERE f.length = (SELECT MIN(m.length) FROM AppBundle:Film m WHERE m.length > 2700)'
        );
        $filmsMinLength = $query->setMaxResults(1)->getResult();

        //unknwow length movie
        $query = $em->createQuery(
            'SELECT f.filmId as filmId, f.title as title FROM AppBundle:Film f WHERE f.length = 0'
        );
        $filmsNoLength = $query->getResult();

        //length problem movie
        $query = $em->createQuery(
            'SELECT f.filmId as filmId, f.title as title, f.length as length FROM AppBundle:Film f WHERE f.length != 0 AND f.length < 2000 OR f.length > 15000'
        );
        $filmsPbLength = $query->getResult();

        //All stage show
        $shows = $em->getRepository('AppBundle:StageShow')->findAll();

        //50 Last Stage Shows
        $query = $em->createQuery(
            'SELECT s.title as title FROM AppBundle:StageShow s ORDER BY s.opening DESC'
        );
        $last100shows = $query->setMaxResults(50)->getResult();

        //Longest Runnning Stage Shows
        $query = $em->createQuery(
            'SELECT s.title as title, s.ibdb as ibdb FROM AppBundle:StageShow s WHERE s.closing < 19720101 AND s.opening > 19270101  ORDER BY s.count DESC'
        );
        $longRunShows = $query->setMaxResults(50)->getResult();

        //Number Stage Show by Year (native ne marche pas)
        // $rsm = new ResultSetMapping();
        // $query = $em->createNativeQuery('SELECT title FROM stageShow ', $rsm);
        // $nbShowsByYear = $query->getResult();

        //All Persons
        $persons = $em->getRepository('AppBundle:Person')->findAll();

        //all director

        //all lyricist

        //all composer

        return $this->render('web/stats/index.html.twig', array(
            'nbFilmsByYear' => $nbFilmsByYear,
            'nbNumbersByYear' => $nbNumbersByYear,
            'numbers' => $numbers,
            'films' => $films,
            'shows' => $shows,
            'persons' => $persons,
            'nbFilmsWithNumber'=> $nbFilmsWithNumber,
            'last10Films' => $last10Films,
            'filmsLength' => $filmsLength,
            'filmsAverageLength' => $filmsAverageLength,
            'filmsMaxLength' => $filmsMaxLength,
            'filmsMinLength' => $filmsMinLength,
            'source1ByYear' => $source1ByYear,
            'nbFilmsWithNumber' => $nbFilmsWithNumber,
            'filmsNoLength' => $filmsNoLength,
            'filmsPbLength' => $filmsPbLength,
            'last100shows' => $last100shows,
            'longRunShows' => $longRunShows,

        ));

    }

}
