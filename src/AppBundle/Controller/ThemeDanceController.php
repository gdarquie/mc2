<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ThemeDanceController extends Controller
{

    /**
     * @Route("/dance", name="getDancing")
     */
    public function getDancing(){

        $em = $this -> getDoctrine()->getManager();

        //all dancing
        $query = $em -> createQuery('SELECT t FROM AppBundle:Thesaurus t JOIN t.code c WHERE c.content = :type');
        $query->setParameter('type', 'dancing_type');
        $dancing = $query->getResult();

        //all sub-genre
        $query = $em -> createQuery('SELECT t FROM AppBundle:Thesaurus t JOIN t.code c WHERE c.content = :type');
        $query->setParameter('type', 'dance_subgenre');
        $subgenre = $query->getResult();

        //all content
        $query = $em -> createQuery('SELECT t FROM AppBundle:Thesaurus t JOIN t.code c WHERE c.content = :type');
        $query->setParameter('type', 'dance_content');
        $content = $query->getResult();

        //top dancing
        $query = $em -> createQuery('SELECT t.title as title, t.id as id, COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.dancing_type t JOIN t.code c WHERE c.content = :type AND t.title != \'NA\' GROUP BY t.id ORDER BY title');
        $query->setParameter('type', 'dancing_type');
        $populardancing = $query->getResult();

        //top subgenre
        $query = $em -> createQuery('SELECT t.title as title, t.id as id, COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.dance_subgenre t JOIN t.code c WHERE c.content = :type GROUP BY t.id ORDER BY title');
        $query->setParameter('type', 'dance_subgenre');
        $popularsubgenre = $query->getResult();

        //top content
        $query = $em -> createQuery('SELECT t.title as title, t.id as id, COUNT(t.title) as nb FROM AppBundle:Number n JOIN n.dance_content t JOIN t.code c WHERE c.content = :type GROUP BY t.id ORDER BY title');
        $query->setParameter('type', 'dance_content');
        $popularcontent = $query->getResult();

        //number of danced numbers
        $query = $em -> createQuery('SELECT COUNT(t.id) as nb FROM AppBundle:Number n JOIN n.dancing_type t JOIN t.code c WHERE c.content =:type AND t.title != :na');
        $query->setParameter('type', 'dancing_type');
        $query->setParameter('na', 'NA');
        $numberDancedNumber = $query->getSingleResult();

        //number of danced numbers
        $query = $em -> createQuery('SELECT COUNT(DISTINCT(f.filmId)) as nb FROM AppBundle:Number n JOIN n.dancing_type t JOIN n.film f JOIN t.code c WHERE c.content = :type AND t.title != :na');
        $query->setParameter('type', 'dancing_type');
        $query->setParameter('na', 'NA');
        $nbfilmsWithDancedNumber = $query->getSingleResult();

        //number of danced numbers (other technic to count)
        $query = $em -> createQuery('SELECT COUNT(n.id) as nb FROM AppBundle:Number n WHERE n.performance_thesaurus = :instru OR n.performance_thesaurus = :song ');
        $query->setParameter('instru', 'instrumental+dance');
        $query->setParameter('song', 'song+dance');
        $numberDancedNumber2 = $query->getSingleResult();

        //average number of shots by year
        $query = $em -> createQuery('SELECT AVG((n.length)/n.shots) as nb, f.released as released FROM AppBundle:Number n JOIN n.film f WHERE n.shots > 0 AND f.released > 0 GROUP BY f.released');
        $avgNbShots = $query->getResult();


        $query = $em->createQuery("SELECT c.name as name, c.personId, n.title as title, n.id as id, f.title as film, f.filmId as filmId FROM AppBundle:Number n JOIN n.choregraphers c JOIN n.film f GROUP BY n.id");
        $associated_choreographers = $query->getResult();

        $top_associated_choreographers = [];

        for ($i = 0; $i < count($associated_choreographers); $i++) {
            $trouve=0;
            for ($u = 0; $u < count($top_associated_choreographers); $u++) {
                if ($associated_choreographers[$i]['personId'] == $top_associated_choreographers[$u]['personId'] && $trouve==0) {
                    $trouve = 1;
                    $top_associated_choreographers[$u]['total']++;
                }
            }
            if ($trouve == 0) {
                array_push($top_associated_choreographers, array("personId" => $associated_choreographers[$i]['personId'] , "name" => $associated_choreographers[$i]['name'], "total" => 1));
            }
        }

        array_push($top_associated_choreographers, array("personId" => -1 , "name" => "Total", "total" => count($associated_choreographers)));


//        //average number of shots by year for danced number
//        $query = $em -> createQuery('SELECT AVG(n.shots) as nb, f.released as released FROM AppBundle:Number n JOIN f.film f GROUP BY f.released ');
////        $query->setParameter('instru', 'instrumental+dance');
////        $query->setParameter('song', 'song+dance');
//        $avgNbShots = $query->getSingleResult();

        return $this->render('AppBundle:dance:index.html.twig' , array(
            'dancing' => $dancing,
            'subgenre' => $subgenre,
            'content' => $content,
            'populardancing' => $populardancing,
            'popularsubgenre' => $popularsubgenre,
            'popularcontent' => $popularcontent,
            'numberDancedNumber' => $numberDancedNumber,
            'nbfilmsWithDancedNumber' => $nbfilmsWithDancedNumber,
            'numberDancedNumber2' => $numberDancedNumber2,
            'avgNbShots' => $avgNbShots,
            'associated_choreographers' => $associated_choreographers,
            'top_associated_choreographers' => $top_associated_choreographers
        ));

    }

    /**
     * @Route("/dance/dancing-type/{dance}", name="getOneDancingType")
     */
    public function getOneDancing($dance){

        $em = $this->getDoctrine()->getManager();

        //filmsByDance
        $query = $em -> createQuery('SELECT DISTINCT(f.title) as title, f.filmId as filmId, f.idImdb as imdb FROM AppBundle:Film f JOIN f.numbers n JOIN n.dancing_type d WHERE d.id = :dance');
        $query->setParameter('dance', $dance);
        $filmsByDance = $query->getResult();

        //myDance
        $query = $em->createQuery('SELECT DISTINCT(d.title) as title, d.definition FROM AppBundle:Film f JOIN f.numbers n JOIN n.dancing_type d WHERE d.id = :dance');
        $query->setParameter('dance', $dance);
        $myDance = $query->getSingleResult();

        //Genres
        $query = $em->createQuery('SELECT g.title as title, COUNT(f.filmId) as nb FROM AppBundle:Number n JOIN n.film f JOIN n.genre g JOIN n.dancing_type d WHERE d.id = :dance GROUP BY g.id ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $genres = $query->getResult();


        //DancingTypeByYear

        $query = $em->createQuery('SELECT f.released as released, COUNT(DISTINCT (n)) as nb FROM AppBundle:Number n JOIN n.dancing_type d JOIN n.film f WHERE d.id = :dance GROUP BY f.released ');
        $query->setParameter('dance', $dance);
        $dancingTypeByYear = $query->getResult();


        //DancingTypeByYearAll

        $query = $em->createQuery('SELECT f.released as released, COUNT(DISTINCT (n)) as nb FROM AppBundle:Number n JOIN n.dancing_type d JOIN n.film f GROUP BY f.released ');
        $dancingTypeByYearAll = $query->getResult();

        //numbers
        $query = $em->createQuery('SELECT n FROM AppBundle:Number n JOIN n.dancing_type d JOIN n.film f WHERE d.id = :dance ORDER BY f.released ASC');
        $query->setParameter('dance', $dance);
        $numbers = $query->getResult();

        //ensembles
        $query = $em->createQuery('SELECT s.title as title, s.id as id, COUNT(d.id) as nb  FROM AppBundle:Number n JOIN n.dancemble s JOIN n.dancing_type d WHERE d.id = :dance GROUP BY s.title ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $dancembles = $query->getResult();

        //exoticisms
        $query = $em->createQuery('SELECT s.title as title, s.id as id, COUNT(d.id) as nb  FROM AppBundle:Number n JOIN n.exoticism_thesaurus s JOIN n.dancing_type d WHERE d.id = :dance GROUP BY s.title ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $exoticisms = $query->getResult();

        return $this->render('AppBundle:dance:dancing_type.html.twig', array(
            'filmsByDance' => $filmsByDance,
            'myDance' => $myDance,
            'genres' => $genres,
            'dancingTypeByYear' => $dancingTypeByYear,
            'dancingTypeByYearAll' => $dancingTypeByYearAll,
            'numbers' => $numbers,
            'dancembles' => $dancembles,
            'exoticisms' => $exoticisms
        ));

    }

    /**
     * @Route("/dance/dance-content/{dance}", name="getOneDanceContent")
     */
    public function getOneDanceContent($dance){

        $em = $this->getDoctrine()->getManager();

        //filmsByDance
        $query = $em -> createQuery('SELECT DISTINCT(f.title) as title, f.filmId as filmId, f.idImdb as imdb FROM AppBundle:Film f JOIN f.numbers n JOIN n.dance_content d WHERE d.id = :dance');
        $query->setParameter('dance', $dance);
        $filmsByDance = $query->getResult();

        //myDance
        $query = $em->createQuery('SELECT DISTINCT(d.title) as title, d.definition FROM AppBundle:Film f JOIN f.numbers n JOIN n.dance_content d WHERE d.id = :dance');
        $query->setParameter('dance', $dance);
        $myDance = $query->getSingleResult();

        //Genres
        $query = $em->createQuery('SELECT g.title as title, COUNT(f.filmId) as nb FROM AppBundle:Number n JOIN n.film f JOIN n.genre g JOIN n.dance_content d WHERE d.id = :dance GROUP BY g.id ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $genres = $query->getResult();

        //DancingTypeByYear
        $query = $em->createQuery('SELECT f.released as released, COUNT(DISTINCT (n)) as nb FROM AppBundle:Number n JOIN n.dance_content d JOIN n.film f WHERE d.id = :dance GROUP BY f.released ');
        $query->setParameter('dance', $dance);
        $danceContentByYear = $query->getResult();

        //DancingTypeByYear
        $query = $em->createQuery('SELECT f.released as released, COUNT(DISTINCT (n)) as nb FROM AppBundle:Number n JOIN n.dance_content d JOIN n.film f GROUP BY f.released ');
        $danceContentByYearAll = $query->getResult();

        //numbers
        $query = $em->createQuery('SELECT n FROM AppBundle:Number n JOIN n.dance_content d JOIN n.film f WHERE d.id = :dance ORDER BY f.released ASC');
        $query->setParameter('dance', $dance);
        $numbers = $query->getResult();

        //ensembles
        $query = $em->createQuery('SELECT s.title as title, s.id as id, COUNT(d.id) as nb  FROM AppBundle:Number n JOIN n.dancemble s JOIN n.dance_content d WHERE d.id = :dance GROUP BY s.title ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $dancembles = $query->getResult();

        //exoticisms
        $query = $em->createQuery('SELECT s.title as title, s.id as id, COUNT(d.id) as nb  FROM AppBundle:Number n JOIN n.exoticism_thesaurus s JOIN n.dance_content d WHERE d.id = :dance GROUP BY s.title ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $exoticisms = $query->getResult();

        return $this->render('AppBundle:dance:danceContent.html.twig', array(
            'filmsByDance' => $filmsByDance,
            'myDance' => $myDance,
            'genres' => $genres,
            'danceContentByYear' => $danceContentByYear,
            'danceContentByYearAll' => $danceContentByYearAll,
            'numbers' => $numbers,
            'dancembles' => $dancembles,
            'exoticisms' => $exoticisms

        ));
    }

    /**
     * @Route("/dance/dance-subgenre/{dance}", name="getOneDanceSubgenre")
     */
    public function getOneDanceSubgenre($dance){

        $em = $this->getDoctrine()->getManager();

        //filmsByDance
        $query = $em -> createQuery('SELECT DISTINCT(f.title) as title, f.filmId as filmId, f.idImdb as imdb, f.released as released FROM AppBundle:Film f JOIN f.numbers n JOIN n.dance_subgenre d WHERE d.id = :dance ORDER BY f.released ASC');
        $query->setParameter('dance', $dance);
        $filmsByDance = $query->getResult();

        //myDance
        $query = $em->createQuery('SELECT DISTINCT(d.title) as title, d.definition, d.id as id FROM AppBundle:Film f JOIN f.numbers n JOIN n.dance_subgenre d WHERE d.id = :dance');
        $query->setParameter('dance', $dance);
        $myDance = $query->getSingleResult();

        //Genres
        $query = $em->createQuery('SELECT g.title as title, COUNT(f.filmId) as nb FROM AppBundle:Number n JOIN n.film f JOIN n.genre g JOIN n.dance_subgenre d WHERE d.id = :dance GROUP BY g.id ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $genres = $query->getResult();

        //DancingTypeByYear
        $query = $em->createQuery('SELECT f.released as released, COUNT(DISTINCT (n)) as nb FROM AppBundle:Number n JOIN n.dance_subgenre d JOIN n.film f WHERE d.id = :dance GROUP BY f.released ');
        $query->setParameter('dance', $dance);
        $danceSubgenreByYear = $query->getResult();

        //DancingTypeByYear
        $query = $em->createQuery('SELECT f.released as released, COUNT(DISTINCT (n)) as nb FROM AppBundle:Number n JOIN n.dance_subgenre d JOIN n.film f GROUP BY f.released ');
        $danceSubgenreByYearAll = $query->getResult();

        //contents
        $query = $em->createQuery('SELECT s.title as title, s.id as id, COUNT(d.id) as nb  FROM AppBundle:Number n JOIN n.dance_content s JOIN n.dance_subgenre d WHERE d.id = :dance GROUP BY s.title ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $contents = $query->getResult();

        //dancings
        $query = $em->createQuery('SELECT s.title as title, s.id as id, COUNT(d.id) as nb  FROM AppBundle:Number n JOIN n.dancing_type s JOIN n.dance_subgenre d WHERE d.id = :dance GROUP BY s.title ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $dancings = $query->getResult();

        //ensembles
        $query = $em->createQuery('SELECT s.title as title, s.id as id, COUNT(d.id) as nb  FROM AppBundle:Number n JOIN n.dancemble s JOIN n.dance_subgenre d WHERE d.id = :dance GROUP BY s.title ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $dancembles = $query->getResult();

        //costumes
        $query = $em->createQuery('SELECT s.title as title, s.id as id, COUNT(d.id) as nb  FROM AppBundle:Number n JOIN n.costumes s JOIN n.dance_subgenre d WHERE d.id = :dance GROUP BY s.title ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $costumes = $query->getResult();

        //exoticisms
        $query = $em->createQuery('SELECT s.title as title, s.id as id, COUNT(d.id) as nb  FROM AppBundle:Number n JOIN n.exoticism_thesaurus s JOIN n.dance_subgenre d WHERE d.id = :dance GROUP BY s.title ORDER BY nb DESC');
        $query->setParameter('dance', $dance);
        $exoticisms = $query->getResult();

        //films and numbers
        $query = $em->createQuery('SELECT n.title as number, n.id as id, f.title as film FROM AppBundle:Number n JOIN n.film f JOIN n.dance_subgenre d WHERE d.id = :dance');
        $query->setParameter('dance', $dance);
        $numbers = $query->getResult();

        $query = $em->createQuery('SELECT n FROM AppBundle:Number n JOIN n.dance_subgenre d JOIN n.film f WHERE d.id = :dance ORDER BY f.released ASC');
        $query->setParameter('dance', $dance);
        $numbersFinal = $query->getResult();


        return $this->render('AppBundle:dance:danceSubgenre.html.twig', array(
            'filmsByDance' => $filmsByDance,
            'myDance' => $myDance,
            'genres' => $genres,
            'danceSubgenreByYear' => $danceSubgenreByYear,
            'danceSubgenreByYearAll' => $danceSubgenreByYearAll,
            'contents' => $contents,
            'dancings' => $dancings,
            'dancembles' => $dancembles,
            'costumes' => $costumes,
            'exoticisms' => $exoticisms,
            'numbers' => $numbers,
            'numbersFinal' => $numbersFinal

        ));

    }

    /**
     * @Route("/dance/dance-subgenre/{subgenreId}/{code}/{itemId}", name="getOneItemFromDanceSubgenre")
     */
    public function getOneSubgenre($subgenreId, $code, $itemId){

        $em = $this->getDoctrine()->getManager();

        //List of numbers

        $query = $em->createQuery('SELECT n FROM AppBundle:Number n JOIN n.'.$code.' d JOIN n.dance_subgenre s WHERE d.id = :itemId AND s.id = :subgenreId');
        $query->setParameter('itemId', $itemId);
        $query->setParameter('subgenreId', $subgenreId);
        $general = $query->getResult();

        //Subgenre
        $query = $em->createQuery('SELECT t FROM AppBundle:Thesaurus t WHERE t.id = :subgenreId');
        $query->setParameter('subgenreId', $subgenreId);
        $subgenre = $query->getSingleResult();

        //Item
        $query = $em->createQuery('SELECT t FROM AppBundle:Thesaurus t WHERE t.id = :itemId');
        $query->setParameter('itemId', $itemId);
        $item = $query->getSingleResult();


        //Number of items by year

        $query = $em->createQuery('SELECT f.released as released, COUNT(d.id) as nb FROM AppBundle:Number n JOIN n.'.$code.' d JOIN n.dance_subgenre s JOIN n.film f WHERE d.id = :itemId AND s.id = :subgenreId GROUP BY f.released ORDER by f.released ASC');
        $query->setParameter('itemId', $itemId);
        $query->setParameter('subgenreId', $subgenreId);
        $itemsByYear = $query->getResult();


        //Performers

        $query = $em->createQuery('SELECT p.name as name, COUNT(p.name) as nb, p.gender as gender FROM AppBundle:Number n JOIN n.'.$code.' d JOIN n.dance_subgenre s JOIN n.performers p WHERE d.id = :itemId AND s.id = :subgenreId GROUP BY p.name ORDER BY nb DESC');
        $query->setParameter('itemId', $itemId);
        $query->setParameter('subgenreId', $subgenreId);
        $performers = $query->getResult();

        return $this->render('AppBundle:dance:item.html.twig', array(
            'general' => $general,
            'subgenre' => $subgenre,
            'item' => $item,
            'itemsByYear' => $itemsByYear,
            'performers' => $performers
        ));

    }
}
