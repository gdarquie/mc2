<?php

namespace AppBundle\Controller;

use AppBundle\Component\DefaultHander;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
//Home Page
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //all films
        $films = $em->getRepository('AppBundle:Film')->findAll();

        //get user
        $user = $this->getUser();

        //Films with numbers
        $filmsWithNumber = $em->getRepository('AppBundle:Film')->findFilmWithNumber()->getQuery()->getResult();

        //numbers
        $numbers = $em->getRepository('AppBundle:Number')->findAll();

        //All Persons
        $persons = $em->getRepository('AppBundle:Person')->findAll();

        //My numbers
        $myNumbers = "";
        $myFilms = "";

        if($this->getUser()) {
            $user = $this->getUser()->getId();
            $query = $em->createQuery('SELECT n FROM AppBundle:Number n JOIN n.editors e WHERE e.id = :user ORDER BY n.last_update DESC');
            $query->setParameter('user', $user );
            $myNumbers = $query->getResult();

            $query = $em->createQuery('SELECT n FROM AppBundle:Number n JOIN n.editors e WHERE e.id = :user GROUP BY n.film')
                ->setParameter('user', $user)
            ;
            $myFilms = $query->getResult();
        }

        $query = $em->createQuery(
            'SELECT COUNT(f.filmId) as nb, f.released as year FROM AppBundle:Film f  WHERE f.released > 1900 GROUP BY f.released'
        );
        $nbFilmsByYear = $query->getResult();

        $query = $em->createQuery(
            'SELECT COUNT(f.filmId) as nb, f.released as year, f.idImdb as idImdb FROM AppBundle:Film f  WHERE f.released > 1900 AND f.filmId IN (SELECT IDENTITY(n.film) FROM AppBundle:Number n WHERE n.film != 0)GROUP BY f.released'
        );
        $nbFilmsWithNumbersByYear = $query->getResult();

        //All numbers by Year
        $query = $em->createQuery(
            'SELECT f.released, COUNT(n.title) as nb, COUNT(DISTINCT(f.title)) as nbFilms FROM AppBundle:Film f LEFT JOIN f.numbers n WHERE f.released > 0 GROUP BY f.released   ORDER BY f.released ASC'
        );
        $nbNumbersByYear = $query->getResult();

        return $this->render('AppBundle:default:index.html.twig', array(
            'films' => $films,
            'filmsWithNumber' => $filmsWithNumber,
            'persons' => $persons,
            'numbers' => $numbers,
            'myNumbers' => $myNumbers,
            'myFilms' => $myFilms,
            'user' => $user,
            'nbFilmsByYear' => $nbFilmsByYear,
            'nbFilmsWithNumbersByYear' => $nbFilmsWithNumbersByYear,
            'nbNumbersByYear' => $nbNumbersByYear
        ));
    }


    /**
     * @Route("/howto", name="howto")
     */
    public function howto(){

        return $this->render('AppBundle:other:howto.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
    public function apropos(){

        return $this->render('AppBundle:other:about.html.twig');
    }

    /**
     * @Route("/content", name="content")
     */
    public function contentTo(){

        return $this->render('AppBundle:other:content.html.twig');
    }


    /**
     * @Route("/news", name="news")
     */
    public function newTo(){

        return $this->render('AppBundle:other:news.html.twig');
    }

    public function getHandler()
    {
        return new DefaultHander($this->getDoctrine()->getManager());
    }

}
