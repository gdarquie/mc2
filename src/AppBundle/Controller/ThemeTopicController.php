<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ThemeTopicController extends Controller
{

    /**
     * @Route("/mood", name="getMood")
     */
    public function getMood(){

        $em = $this -> getDoctrine()->getManager();

        //general Mood

        //all mood
        $query = $em -> createQuery('SELECT t FROM AppBundle:Thesaurus t JOIN t.code c WHERE c.content = :code');
        $query->setParameter('code', 'general_mood');
        $mood = $query->getResult();

        //all most popular exoticism in numbers
        $query = $em -> createQuery('SELECT t.id as itemId, t.title as title, COUNT(t.title) as nb, c.title as category FROM AppBundle:Number n JOIN n.general_mood t JOIN t.code c WHERE c.content = :code GROUP BY t.id ORDER BY nb DESC');
        $query->setParameter('code', 'general_mood');
        $popularmood = $query->getResult();

        $query = $em -> createQuery('SELECT t.id as itemId, t.title as title, COUNT(t.title) as nb, c.title as category FROM AppBundle:Number n JOIN n.general_mood t JOIN t.code c WHERE c.content = :code GROUP BY t.id ORDER BY title');
        $query->setParameter('code', 'mogeneral_moodod');
        $popularmoodCartouche = $query->getResult();

        //the most popular
        $query = $em -> createQuery('SELECT t.title as title,  COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.general_mood t JOIN t.code c WHERE c.content = :code GROUP BY t.id ORDER BY nb DESC')->setMaxResults(1);
        $query->setParameter('code', 'general_mood');
        $mostPopular = $query->getSingleResult();

        //total of cited exoticism
        $query = $em -> createQuery('SELECT COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.general_mood t JOIN t.code c WHERE c.content = :code');
        $query->setParameter('code', 'general_mood');
        $total = $query->getSingleResult();

        //total of number with exoticism
        $query = $em -> createQuery('SELECT COUNT(DISTINCT(n.id)) as nb FROM AppBundle:Number n JOIN n.general_mood t JOIN t.code c WHERE c.content = :code');
        $query->setParameter('code', 'general_mood');
        $totalNumber = $query->getSingleResult();

        //genre

        //all mood
        $query = $em -> createQuery('SELECT t FROM AppBundle:Thesaurus t JOIN t.code c WHERE c.content = :code');
        $query->setParameter('code', 'genre');
        $moodGenre = $query->getResult();

        //all most popular exoticism in numbers
        $query = $em -> createQuery('SELECT t.id as itemId, t.title as title, COUNT(t.title) as nb, c.title as category FROM AppBundle:Number n JOIN n.genre t JOIN t.code c WHERE c.content = :code GROUP BY t.id ORDER BY nb DESC');
        $query->setParameter('code', 'genre');
        $popularmoodGenre = $query->getResult();


        //all most popular exoticism in numbers
        $query = $em -> createQuery('SELECT t.id as itemId, t.title as title, COUNT(t.title) as nb, c.title as category FROM AppBundle:Number n JOIN n.genre t JOIN t.code c WHERE c.content = :code GROUP BY t.id ORDER BY title');
        $query->setParameter('code', 'genre');
        $popularmoodGenreCartouche = $query->getResult();

        //the most popular
        $query = $em -> createQuery('SELECT t.title as title,  COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.genre t JOIN t.code c WHERE c.content = :code GROUP BY t.id ORDER BY nb DESC')->setMaxResults(1);
        $query->setParameter('code', 'genre');
        $mostPopularGenre = $query->getSingleResult();

        //total of cited exoticism
        $query = $em -> createQuery('SELECT COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.genre t JOIN t.code c WHERE c.content = :code');
        $query->setParameter('code', 'genre');
        $totalGenre = $query->getSingleResult();

        //total of number with exoticism
        $query = $em -> createQuery('SELECT COUNT(DISTINCT(n.id)) as nb FROM AppBundle:Number n JOIN n.genre t JOIN t.code c WHERE c.content = :code');

        $query->setParameter('code', 'genre');
        $totalNumberGenre = $query->getSingleResult();


        return $this->render('AppBundle:topic:mood.html.twig' , array(
            'mood' => $mood,
            'popularmood' => $popularmood,
            'popularmoodCartouche' => $popularmoodCartouche,
            'mostPopular' => $mostPopular,
            'total' => $total,
            'totalNumber' => $totalNumber,
            'moodGenre' => $moodGenre,
            'popularmoodGenre' => $popularmoodGenre,
            'popularmoodGenreCartouche' => $popularmoodGenreCartouche,
            'mostPopularGenre' => $mostPopularGenre,
            'totalGenre' => $totalGenre,
            'totalNumberGenre' => $totalNumberGenre
        ));

    }

    /**
     * @Route("/mood/{itemId}", name="getOneMood")
     */
    public function getOneMood($itemId){

        $em = $this -> getDoctrine()->getManager();

        //code

        $query = $em->createQuery('SELECT c.content FROM AppBundle:Thesaurus t JOIN t.code c WHERE t.id = :item');
        $query->setParameter('item', $itemId);
        $code = $query->getSingleResult();
        $code = $code['content'];

        //1 exoticism

        $query = $em -> createQuery('SELECT t FROM AppBundle:Thesaurus t JOIN t.code c WHERE c.content = :code AND t.id = :item ');
        $query->setParameter('code', $code);
        $query->setParameter('item', $itemId);
        $mood = $query->getResult();


        //list of numbers for 1 mood

        $query = $em->createQuery('SELECT n FROM AppBundle:Number n JOIN n.'.$code.' g JOIN n.film f WHERE g.id = :item ORDER by f.filmId');
        $query->setParameter('item', $itemId);
        $numbers = $query->getResult();


        //list of films for 1 exoticism

        $query = $em -> createQuery('SELECT f.title as filmTitle, f.filmId as filmId, f.idImdb as imdb, COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.'.$code.' t JOIN n.film f  JOIN t.code c WHERE c.content = :code AND t.id = :item GROUP BY f.filmId');
        $query->setParameter('code', $code);
        $query->setParameter('item', $itemId);
        $films = $query->getResult();


        //source as label?
        $query = $em -> createQuery('SELECT s.title as label, count(n.id) as value FROM AppBundle:Number n JOIN n.source_thesaurus s JOIN n.'.$code.' e JOIN e.code c WHERE c.content = :code AND e.id = :item GROUP BY label ORDER BY value desc');
        $query->setParameter('code', $code);
        $query->setParameter('item', $itemId);
        $sources = $query->getResult();
        $valNull = 0;
        for ($i=0; $i<count($sources); $i++){
            if ($sources[$i]["label"] === "") {
                $valNull = $sources[$i]["value"];
                array_splice($sources, $i, 1);
            }
        }
        for ($i=0; $i<count($sources); $i++){
            if ($sources[$i]["label"] == NULL) {
                $sources[$i]["value"] += $valNull;
                $sources[$i]["label"] = "NA";
            }
        }
        $sources = new JsonResponse($sources);


//
//
//        //number of exoticism by year
//        $query = $em -> createQuery('SELECT e.title, f.released as released, COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.exoticism_thesaurus e JOIN n.film f  JOIN t.code c WHERE c.content = :code AND e.title = :item GROUP BY f.released ORDER BY f.released ASC');
//        $query->setParameter('type', 'exoticism');
//        $query->setParameter('item', $item);
//        $exoticismByYear = $query->getResult();


        return $this->render('AppBundle:themes:onemood.html.twig' , array(
            'mood' => $mood,
            'numbers' => $numbers,
            'films' => $films,
            'sources' => $sources
//            'exoticismByYear' => $exoticismByYear
        ));

    }
}
