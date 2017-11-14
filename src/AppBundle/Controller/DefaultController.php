<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\ResultSetMapping;


class DefaultController extends Controller
{

//Home Page

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        // dump($em->getRepository('AppBundle:Number'));

        //all films
        $films = $em->getRepository('AppBundle:Film')->findAll();
        // $films = $em->getRepository('AppBundle:Film')
        //     ->findAllOrderdByTitle();

        //get user
        $user = $this->getUser();

        //Films with number
        $query = $em->createQuery('SELECT f.filmId as filmId, f.title as title, f.idImdb as idImdb, f.released as released  FROM AppBundle:Film f WHERE f.filmId IN (SELECT IDENTITY(n.film) FROM AppBundle:Number n WHERE n.film != 0) ORDER BY f.released ASC');
        $filmsWithNumber = $query->getResult();

        $numbers = $em->getRepository('AppBundle:Number')->findAll();


        $numbers = $em->getRepository('AppBundle:Number')->findAll();

        //All Persons
        $persons = $em->getRepository('AppBundle:Person')->findAll();

        //My numbers

        $myNumbers = "";
        $myFilms = "";

        if($this->getUser()){
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
     * @Route("/news", name="news")
     */
    public function newTo(){

        return $this->render('AppBundle:other:news.html.twig');
    }


}
