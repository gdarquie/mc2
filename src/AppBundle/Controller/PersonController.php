<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class PersonController extends Controller
{
    /**
     * @Route("/person/{personId}", name = "person")
     */
    public function getOnePerson($personId){

        //Get Person
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT p FROM AppBundle:Person p WHERE p.personId = :person");
        $query->setParameter('person', $personId);
        $person = $query->getSingleResult();

        //Get all numbers for the person
        $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId);
        $numbers_as_performers = $query->getResult();

        //Get all numbers for the person
        $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.choregraphers p WHERE p.personId = :person");
        $query->setParameter('person', $personId);
        $numbers_as_choreographers = $query->getResult();

        //Get all id for the person (as performers)
        $query = $em->createQuery("SELECT n.id FROM AppBundle:Number n JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId);
        $list_id = $query->getResult();

        //AVG shot length
        $query = $em->createQuery("SELECT (n.length)/10 FROM AppBundle:Number n JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId);
        $shot_length = $query->getResult();

        //Get all Performances
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title, t.id as id, t.definition FROM AppBundle:Number n JOIN n.performance_thesaurus t GROUP BY t.title ");
        $performances = $query->getResult();

        //Get a Performance
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title, t.id as id FROM AppBundle:Number n JOIN n.performance_thesaurus t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ");
        $query->setParameter('person', $personId );
        $performance = $query->getResult();

        //Get all structures
        $query = $em->createQuery("SELECT COUNT(DISTINCT(n.id)) as nb, t.title, t.definition FROM AppBundle:Number n JOIN n.structure t JOIN n.performers p GROUP BY t.title");
        $structures = $query->getResult();

        //Get total of numbers [vérifier]
        $query = $em->createQuery("SELECT COUNT(DISTINCT(n.id)) as total FROM AppBundle:Number n JOIN n.structure t JOIN n.performers p");
        $structures_total = $query->getSingleResult();

        //Get ????
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title, t.id as id FROM AppBundle:Number n JOIN n.structure t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ");
        $query->setParameter('person', $personId );
        $structure = $query->getResult();

//        Topics part (genre, general_mood)

        //All genres
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title as title, t.id as id FROM AppBundle:Number n JOIN n.genre t JOIN n.performers p GROUP BY t.title ORDER BY nb DESC");
        $genres = $query->getResult();

        //Genre for the person
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title, t.id as id FROM AppBundle:Number n JOIN n.genre t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ORDER BY nb DESC");
        $query->setParameter('person', $personId );
        $genre = $query->getResult();

        //All moods
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title FROM AppBundle:Number n JOIN n.general_mood t JOIN n.performers p GROUP BY t.title ORDER BY nb DESC");
        $moods = $query->getResult();

        //Moods for the person
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title, t.id as id FROM AppBundle:Number n JOIN n.general_mood t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ORDER BY nb DESC");
        $query->setParameter('person', $personId );
        $mood = $query->getResult();

//      Exoticism

        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN n.performers p GROUP BY t.title ORDER BY nb DESC");
        $exoticisms = $query->getResult();

        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title, t.id as id FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ORDER BY nb DESC");
        $query->setParameter('person', $personId );
        $exoticism = $query->getResult();

//       Sources

        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title FROM AppBundle:Number n JOIN n.source_thesaurus t JOIN n.performers p GROUP BY t.title ORDER BY nb DESC");
        $sources = $query->getResult();

        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title, t.id as id FROM AppBundle:Number n JOIN n.source_thesaurus t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ORDER BY nb DESC");
        $query->setParameter('person', $personId );
        $source = $query->getResult();

//      Dancing
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title FROM AppBundle:Number n JOIN n.dancing_type t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ORDER BY nb DESC");
        $query->setParameter('person', $personId );
        $dancing = $query->getResult();

//      Musical
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title FROM AppBundle:Number n JOIN n.musical_thesaurus t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ORDER BY nb DESC");
        $query->setParameter('person', $personId );
        $musical = $query->getResult();

//      Completenesses
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title, t.id as id, t.definition FROM AppBundle:Number n JOIN n.completeness_thesaurus t GROUP BY t.title ORDER BY nb DESC");
        $completenesses = $query->getResult();

//      Completeness
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title, t.id as id FROM AppBundle:Number n JOIN n.completeness_thesaurus t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ORDER BY nb DESC");
        $query->setParameter('person', $personId );
        $completeness = $query->getResult();

//      Completes ???
        $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n JOIN n.completeness_thesaurus t JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId );
        $completes = $query->getSingleResult();

//      Complete ???
        $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n JOIN n.completeness_thesaurus t JOIN n.performers p WHERE p.personId = :person AND t.title = :complete");
        $query->setParameter('person', $personId );
        $query->setParameter('complete', 'complete' );
        $complete = $query->getSingleResult();

        $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n JOIN n.complet_options t JOIN n.performers p WHERE p.personId = :person AND t.title = :occurences");
        $query->setParameter('person', $personId );
        $query->setParameter('occurences', 'multiple occurrences of a song or partial reprise' );
        $occurences = $query->getSingleResult();

        $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n JOIN n.complet_options t JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId );
        $completOptions = $query->getSingleResult();

        //diegetic
        $query = $em->createQuery("SELECT COUNT(t.title) as nb, t.title FROM AppBundle:Number n JOIN n.diegetic_thesaurus t GROUP BY t.title ORDER BY nb DESC");
        $diegetics = $query->getResult();

        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title, t.id as id FROM AppBundle:Number n JOIN n.diegetic_thesaurus t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ORDER BY nb DESC");
        $query->setParameter('person', $personId );
        $diegetic = $query->getResult();

        //Calculate presence
        $query = $em->createQuery("SELECT DISTINCT(f.filmId) as filmId FROM AppBundle:Number n JOIN n.film f JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId );
        $idFilmsWithPerson = $query->getResult();
////        $idFilmsWithPerson = [4349,4606,4690,5030];

        //total des durées des numbers pour chaque film avec person (pourquoi HAVING ne marche pas)
        $query = $em->createQuery("SELECT SUM((n.endTc - n.beginTc)) as total, f.length as length, f.title as title, f.released, f.filmId FROM AppBundle:Film f JOIN f.numbers n WHERE f.filmId IN (:film) GROUP BY f.filmId ORDER BY f.released ASC, f.title, f.filmId");
//        $query->setParameter('person', $name );
        $query->setParameter('film', $idFilmsWithPerson );
        $lengthTotal = $query->getResult();

        $query = $em->createQuery("SELECT SUM((n.endTc - n.beginTc)) as total, f.title as title, f.released as released FROM AppBundle:Number n JOIN n.performers p JOIN n.film f WHERE p.personId = :person  AND f.filmId IN (:film) GROUP BY f.filmId, f.title ORDER BY f.released ASC, f.title, f.filmId");
        $query->setParameter('person', $personId );
        $query->setParameter('film', $idFilmsWithPerson );
        $lengthTotalForPerson = $query->getResult();

        if(count($lengthTotalForPerson) == count($lengthTotal)) {

            $ratio = [];
            for ($i = 0; $i < count($lengthTotalForPerson); $i++) {

                array_push($ratio, array("all" => $lengthTotal[$i]['total'], "title" => $lengthTotal[$i]['title'], "length" => $lengthTotal[$i]['length'], "released" => $lengthTotal[$i]['released'], "one" => $lengthTotalForPerson[$i]['total'] ));
            }
        }

        //durée moyenne pour d'un shot pour un number
        $query = $em->createQuery("SELECT DISTINCT(n.id), AVG(n.shots) as average FROM AppBundle:Number n JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId );
        $avgShotForPerson = $query->getResult();
        //rapporter par rapport à la durée de plans


        //une moyenne par films
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title FROM AppBundle:Number n JOIN n.diegetic_thesaurus t JOIN n.performers p WHERE p.personId = :person GROUP BY t.title ORDER BY nb DESC");
        $query->setParameter('person', $personId );
        $presence = $query->getResult();

        //Average length a shot for a performer
        $query = $em->createQuery("SELECT (SUM(n.length))/(SUM(n.shots)) as average FROM AppBundle:Number n JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId);
        $sumLengthShot = $query->getSingleResult();

        $query = $em->createQuery("SELECT (AVG(n.length))/(AVG(n.shots)) as average FROM AppBundle:Number n JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId);
        $avgLengthShot = $query->getSingleResult();

        //Associated persons (à finir)

        //choreographers
        $query = $em->createQuery("SELECT c.name as name, c.personId, n.title as title, n.id as id, f.title as film, f.filmId as filmId FROM AppBundle:Number n JOIN n.choregraphers c JOIN n.performers p JOIN n.film f WHERE p.personId = :person GROUP BY n.id");
        $query->setParameter('person', $personId);
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



//        $associated_choreographers_final = [];
//        for ($i = 0; $i < count($associated_choreographers); $i++) {
//            $trouve=0;
//            for ($u = 0; $u < count($associated_choreographers_final); $u++) {
//                if ($associated_choreographers_final[$u]['name'] == $associated_choreographers[$i]['name'] && $associated_choreographers_final[$u]['film'] == $associated_choreographers[$i]['film'] && $trouve==0) {
//                    $trouve = 1;
//                    array_push($associated_choreographers_final[$u]["number"], array("title" => $associated_choreographers[$i]['title'], "id" => $associated_choreographers[$i]['id']));
//                }
//            }
//            if ($trouve == 0) {
//                array_push($associated_choreographers_final, array("name" => $associated_choreographers[$i]['name'], "number" => [], "film" => $associated_choreographers[$i]['film'], "filmId" => $associated_choreographers[$i]['filmId'] ));
//                array_push($associated_choreographers_final[count($associated_choreographers_final)-1]["number"], array("title" => $associated_choreographers[$i]['title'], "id" => $associated_choreographers[$i]['id']));
//            }
//        }


        //composers
        $query = $em->createQuery("SELECT n.title as number, s.title as song, c.name as name, c.personId as personId, n.id as id, f.title as film, f.filmId as filmId FROM AppBundle:Number n JOIN n.song s JOIN s.composer c JOIN n.performers p JOIN n.film f WHERE p.personId = :person");
        $query->setParameter('person', $personId);
        $associated_composers = $query->getResult();


        $top_associated_composers = [];

        for ($i = 0; $i < count($associated_composers); $i++) {
            $trouve=0;
            for ($u = 0; $u < count($top_associated_composers); $u++) {
                if ($associated_composers[$i]['personId'] == $top_associated_composers[$u]['personId'] && $trouve==0) {
                    $trouve = 1;
                    $top_associated_composers[$u]['total']++;
                }
            }
            if ($trouve == 0) {
                array_push($top_associated_composers, array("personId" => $associated_composers[$i]['personId'] , "name" => $associated_composers[$i]['name'], "total" => 1));
            }
        }

        array_push($top_associated_composers, array("personId" => -1 , "name" => "Total", "total" => count($associated_composers)));





//        $associated_composers_final = [];
//        for ($i = 0; $i < count($associated_composers); $i++) {
//            $trouve=0;
//            for ($u = 0; $u < count($associated_composers_final); $u++) {
//                if ($associated_composers_final[$u]['name'] == $associated_composers[$i]['name'] && $associated_composers_final[$u]['film'] == $associated_composers[$i]['film'] && $trouve==0) {
//                    $trouve = 1;
//                    array_push($associated_composers_final[$u]["number"], array("title" => $associated_composers[$i]['title'], "id" => $associated_composers[$i]['id']));
//                }
//            }
//            if ($trouve == 0) {
//                array_push($associated_composers_final, array("name" => $associated_composers[$i]['name'], "number" => [], "film" => $associated_composers[$i]['film'], "filmId" => $associated_composers[$i]['filmId'] ));
//                array_push($associated_composers_final[count($associated_composers_final)-1]["number"], array("title" => $associated_composers[$i]['title'], "id" => $associated_composers[$i]['id']));
//            }
//        }

        //lyricists
        $query = $em->createQuery("SELECT n.title as number, s.title as song, l.name as name, l.personId as personId, n.id as id, f.title as film, f.filmId as filmId FROM AppBundle:Number n JOIN n.song s JOIN s.lyricist l JOIN n.performers p JOIN n.film f WHERE p.personId = :person");
        $query->setParameter('person', $personId);
        $associated_lyricists = $query->getResult();

        $top_associated_lyricists = [];

        for ($i = 0; $i < count($associated_lyricists); $i++) {
            $trouve=0;
            for ($u = 0; $u < count($top_associated_lyricists); $u++) {
                if ($associated_lyricists[$i]['personId'] == $top_associated_lyricists[$u]['personId'] && $trouve==0) {
                    $trouve = 1;
                    $top_associated_lyricists[$u]['total']++;
                }
            }
            if ($trouve == 0) {
                array_push($top_associated_lyricists, array("personId" => $associated_lyricists[$i]['personId'] , "name" => $associated_lyricists[$i]['name'], "total" => 1));
            }
        }

        array_push($top_associated_lyricists, array("personId" => -1 , "name" => "Total", "total" => count($associated_lyricists)));



//        //films of a person
//        $query = $em->createQuery("SELECT f.filmId as filmId, f.title as title, f.idImdb as imdb, f.released as released FROM AppBundle:Number n JOIN n.film f JOIN n.performers p JOIN n.director d WHERE p.personId = :person OR d.personId = :person GROUP BY f.filmId ORDER BY f.released ASC");
//        $query->setParameter('person', $personId );
//        $filmsPerson = $query->getResult();

        //films of a person
        $query = $em->createQuery("SELECT f.filmId as filmId, f.title as title, f.idImdb as imdb, f.released as released FROM AppBundle:Song s JOIN s.composer co JOIN s.lyricist l JOIN s.number n JOIN n.film f WHERE co.personId = :person OR l.personId = :person GROUP BY f.filmId ORDER BY f.released ASC");
        $query->setParameter('person', $personId );
        $filmsPerson = $query->getResult();


        return $this->render('AppBundle:person:person.html.twig', array(
            'person' => $person,
            'numbers_as_performers' => $numbers_as_performers,
            'performances' => $performances,
            'performance' => $performance,
            'structure' => $structure,
            'structures' => $structures,
            'genres' => $genres,
            'genre' => $genre,
            'source' => $source,
            'sources' => $sources,
            'dancing' => $dancing,
            'musical' => $musical,
            'completeness' => $completeness,
            'completenesses' => $completenesses,
            'completes' => $completes,
            'complete' => $complete,
            'occurences' => $occurences,
            'completOptions' => $completOptions,
            'diegetic' => $diegetic,
            'diegetics' => $diegetics,
            'lengthTotal' => $lengthTotal,
            'filmsWithPerson' => $idFilmsWithPerson,
            'lengthTotalForPerson' =>$lengthTotalForPerson,
            'ratio' => $ratio,
            'structures_total' => $structures_total,
            'sumLengthShot' => $sumLengthShot,
            'avgShotForPerson' => $avgShotForPerson,
            'moods' => $moods,
            'mood' => $mood,
            'exoticisms' => $exoticisms,
            'exoticism' => $exoticism,
            '$list_id' => $list_id,
            'shot_length' => $shot_length,
            'avgLengthShot' => $avgLengthShot,
            'associated_choreographers' => $associated_choreographers,
            'top_associated_choreographers' => $top_associated_choreographers,
            'associated_composers' => $associated_composers,
            'top_associated_composers' => $top_associated_composers,
            'associated_lyricists' => $associated_lyricists,
            'top_associated_lyricists' => $top_associated_lyricists,
            'filmsPerson' => $filmsPerson
        ));
    }

    /**
     * @Route("/person/search/performerId={personId}/id={id}/type={type}", name = "person_search_by_thesaurus")
     */
    public function getNumberForPerformerByThesaurus($personId, $id, $type){


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT p FROM AppBundle:Person p WHERE p.personId = :person ");
        $query->setParameter('person', $personId);
        $person = $query->getSingleResult();

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT t FROM AppBundle:Thesaurus t WHERE t.id = :thesaurus");
        $query->setParameter('thesaurus', $id);
        $thesaurus = $query->getSingleResult();

        if($type == 'topic'){
            $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.genre t JOIN n.performers p WHERE p.personId = :person AND  t.id = :thesaurus");

        }
        elseif($type == 'mood'){
            $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.general_mood t JOIN n.performers p WHERE p.personId = :person AND  t.id = :thesaurus");
        }
        elseif($type == 'exoticism'){
            $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.exoticism_thesaurus t JOIN n.performers p WHERE p.personId = :person AND  t.id = :thesaurus");
        }
        elseif($type == 'source'){
            $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.source_thesaurus t JOIN n.performers p WHERE p.personId = :person AND  t.id = :thesaurus");
        }
        elseif($type == 'diegetic'){
            $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.diegetic_thesaurus t JOIN n.performers p WHERE p.personId = :person AND  t.id = :thesaurus");
        }
        //
        elseif($type == 'completeness'){
            $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.completeness_thesaurus t JOIN n.performers p WHERE p.personId = :person AND  t.id = :thesaurus");
        }
        elseif($type == 'structure'){
            $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.structure t JOIN n.performers p WHERE p.personId = :person AND  t.id = :thesaurus");
        }
        elseif($type == 'diegetic'){
            $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.diegetic_thesaurus t JOIN n.performers p WHERE p.personId = :person AND  t.id = :thesaurus");
        }



        $query->setParameter('person', $personId);
        $query->setParameter('thesaurus', $id);
        $numbers = $query->getResult();


        return $this->render('AppBundle:person:personByItem.html.twig', array(
            'person' => $person,
            'thesaurus' => $thesaurus,
            'numbers' => $numbers
        ));
    }


}


