<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ThemeExoticismController extends Controller
{
    /**
     * @Route("/exoticism", name="getExoticism")
     */
    public function getExoticism(){

        $em = $this -> getDoctrine()->getManager();

        //all exoticism
        $query = $em -> createQuery('SELECT t FROM AppBundle:Thesaurus t JOIN t.code c WHERE c.content = :code');
        $query->setParameter('code', 'exoticism_thesaurus');
        $exoticism = $query->getResult();

        //all most popular exoticism in numbers
        $query = $em -> createQuery('SELECT t.title as title, COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN t.code c  WHERE c.content = :code AND t.id != 436 GROUP BY t.id ORDER BY nb DESC');
        $query->setParameter('code', 'exoticism_thesaurus');
        $popularexoticism = $query->getResult();

        //all most popular exoticism in numbers
        $query = $em -> createQuery('SELECT t.title as title, COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN t.code c WHERE c.content = :code AND t.id != 436 GROUP BY t.id ORDER BY title');
        $query->setParameter('code', 'exoticism_thesaurus');
        $popularexoticismCartouche = $query->getResult();

        $query = $em -> createQuery('SELECT t.title as label, COUNT(t.title) as value FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN t.code c WHERE c.content = :code GROUP BY t.id ORDER BY value DESC')->setMaxResults(12);
        $query->setParameter('code', 'exoticism_thesaurus');
        $popularexoticismJson = $query->getResult();
        $popularexoticismJson = new JsonResponse($popularexoticismJson);


        //the most popular
        $query = $em -> createQuery('SELECT t.title as title,  COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN t.code c  WHERE c.content = :code GROUP BY t.id ORDER BY nb DESC')->setMaxResults(1);
        $query->setParameter('code', 'exoticism_thesaurus');
        $mostPopular = $query->getSingleResult();

        //total of cited exoticism
        $query = $em -> createQuery('SELECT COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN t.code c  WHERE c.content = :code AND t.id != 436');
        $query->setParameter('code', 'exoticism_thesaurus');
        $total = $query->getSingleResult();

        //total of number with exoticism
        $query = $em -> createQuery('SELECT COUNT(DISTINCT(n.id)) as nb FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN t.code c  WHERE c.content = :code AND t.id != 436 ');
        $query->setParameter('code', 'exoticism_thesaurus');
        $totalNumber = $query->getSingleResult();

        //number of exoticism group by decades

        return $this->render('AppBundle:themes:exoticism.html.twig' , array(
            'exoticism' => $exoticism,
            'popularexoticism' => $popularexoticism,
            'popularexoticismCartouche' => $popularexoticismCartouche,
            'popularexoticismJson' => $popularexoticismJson,
            'mostPopular' => $mostPopular,
            'total' => $total,
            'totalNumber' => $totalNumber
        ));

    }

    /**
     * @Route("/exoticism/{item}", name="getOneExoticism")
     */
    public function getOneExoticism($item){

        $em = $this -> getDoctrine()->getManager();

        //1 exoticism
        $query = $em -> createQuery('SELECT t FROM AppBundle:Thesaurus t JOIN t.code c WHERE c.content = :code AND t.title = :item');
        $query->setParameter('code', 'exoticism_thesaurus');
        $query->setParameter('item', $item);
        $exoticism = $query->getResult();

        //list of numbers for 1 exoticism
        $query = $em -> createQuery('SELECT n.title as title, f.title as filmTitle, n.id as id, f.released as released FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN n.film f JOIN t.code c WHERE c.content = :code AND t.title = :item ORDER by f.filmId');
        $query->setParameter('code', 'exoticism_thesaurus');
        $query->setParameter('item', $item);
        $numbers = $query->getResult();

        $query = $em -> createQuery('SELECT n FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN t.code c WHERE c.content = :code AND t.title = :item ORDER by n.id');
        $query->setParameter('code', 'exoticism_thesaurus');
        $query->setParameter('item', $item);
        $numbersTotal = $query->getResult();

        //list of films for 1 exoticism
        $query = $em -> createQuery('SELECT f.title as filmTitle, f.filmId as filmId, f.idImdb as imdb, COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN n.film f  JOIN t.code c WHERE c.content = :code AND t.title = :item GROUP BY f.filmId');
        $query->setParameter('code', 'exoticism_thesaurus');
        $query->setParameter('item', $item);
        $films = $query->getResult();


        //number of exoticism by year
        $query = $em -> createQuery('SELECT t.title, f.released as released, COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN n.film f  JOIN t.code c WHERE c.content = :code AND t.title = :item GROUP BY f.released ORDER BY f.released ASC');
        $query->setParameter('code', 'exoticism_thesaurus');
        $query->setParameter('item', $item);
        $exoticismByYear = $query->getResult();

        $query = $em -> createQuery('SELECT s.title as title, COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN n.film f JOIN f.studios s JOIN t.code c WHERE c.content = :code AND t.title = :item GROUP BY s.studioId ORDER BY nb DESC');
        $query->setParameter('code', 'exoticism_thesaurus');
        $query->setParameter('item', $item);
        $studios = $query->getResult();


        return $this->render('AppBundle:themes:oneexoticism.html.twig' , array(
            'exoticism' => $exoticism,
            'numbers' => $numbers,
            'numbersTotal' => $numbersTotal,
            'films' => $films,
            'exoticismByYear' => $exoticismByYear,
            'studios' => $studios
        ));

    }

}
