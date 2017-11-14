<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Person;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("api/persons")
 */
class PersonController extends Controller
{

    /**
     * @Route("/")
     */
    public function personsAction(){

        //all persons (pae la suite ajouter un critère pour chercher par profession)

        $em = $this->getDoctrine()->getManager();
        $persons = $em->getRepository('AppBundle:Person')->findAll();
        $data = array('person' => array());
        foreach ($persons as $person) {
            $data['person'][] = $this->serializePerson($person);
        }

        $response = new JsonResponse($data, 200);

        return $response;
    }

    private function serializePerson(Person $person)
    {
        return array(
            'personId' => $person->getPersonId(),
            'name' => $person->getName()
        );
    }

    /**
     * @Route("/melviz/diegetic/{personId}", name="api_person_melviz_diegetic")
     */
    public function getMelvizDiegetic($personId)
    {
        $em = $this->getDoctrine()->getManager();

        //total diegetics for each diegetics for one person
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title as title FROM AppBundle:Number n LEFT JOIN n.diegetic_thesaurus t JOIN n.performers p  WHERE p.personId = :person GROUP BY t.title ORDER BY t.title ASC");
        $query->setParameter('person', $personId );
        $diegetic = $query->getResult();

        $max = count($diegetic);
        $max = 9;

        //total diegetics for each diegetics for all
        $query = $em->createQuery("SELECT COUNT(t.title) as nb, t.title as title FROM AppBundle:Number n JOIN n.diegetic_thesaurus t GROUP BY t.title ORDER BY t.title ASC");
        $query->setMaxResults($max);
        $diegetics = $query->getResult();

        $query = $em->createQuery("SELECT t.title as title FROM AppBundle:Number n JOIN n.diegetic_thesaurus t GROUP BY t.title ORDER BY t.title ASC");
        $diegetics_title = $query->getResult();

        //new array for collecting all the value of diegetic even when 0
        $diegetic_format = [];

        $i = 0;
        foreach ($diegetics_title as $item) {

//            dump($item['title']);die;

            $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n LEFT JOIN n.diegetic_thesaurus t JOIN n.performers p  WHERE p.personId = :person AND t.title = :title ORDER BY t.title ASC");
            $query->setParameter('person', $personId );
            $query->setParameter('title', $item['title']);
            $selectDiegetic = $query->getResult();

            $selectDiegetic['title'] = $item['title'];
            $selectDiegetic['nb'] = $selectDiegetic[0]['nb'];
            unset($selectDiegetic[0]); //for cleaning the array (juste two rows)

//                        dump($selectDiegetic['title']);die;

            $diegetic_format[$i]['title'] = $selectDiegetic['title'];
            $diegetic_format[$i]['nb']= $selectDiegetic['nb'];
            $i++;

        }

//        dump($diegetic_format);die;

        //total of numbers with a diegetic
        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.diegetic_thesaurus t ");
        $totalNumbers = $query->getSingleResult();
//
        //total of numbers with a diegetic for the person
        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.diegetic_thesaurus t JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId );
        $totalNumbersForPerson = $query->getSingleResult();

        $diegeticsArray = array();
        for ($i = 0; $i < count($diegetic_format); $i++) {

            if (count($diegetic_format) == count($diegetics)){

                //ajouter une condition si est nul
                $requete = $diegetics[$i]['title'];
                $requete4 = $diegetic_format[$i]['title'];

                if(!ISSET($diegetic_format[$i]['nb'])){
                    $requete2 = 0;
                }
                else{
                    $requete2 = $diegetic_format[$i]['nb'];
                }
                $requete3 = $diegetics[$i]['nb'];

                $key = $i;

                $diegeticsArray[$key]['label'] = $requete;
                $diegeticsArray[$key]['label'] = $requete4;
                $diegeticsArray[$key]['one_item'] = round((intval($requete2) / intval($totalNumbersForPerson['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
                $diegeticsArray[$key]['all_items'] = round((intval($requete3) / intval($totalNumbers['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
            }

        }

//        dump($diegeticsArray);die;
        return new JsonResponse($diegeticsArray);
    }


    /**
     * @Route("/melviz/performance/{personId}", name="api_person_melviz_performance")
     */
    public function getMelvizPerformance($personId)
    {
        $em = $this->getDoctrine()->getManager();

        //total performances for each performances for one person
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title as title FROM AppBundle:Number n LEFT JOIN n.performance_thesaurus t JOIN n.performers p  WHERE p.personId = :person GROUP BY t.title ORDER BY t.title ASC");
        $query->setParameter('person', $personId );
        $performance = $query->getResult();

        $max = count($performance);
        $max = 9;

        //total performances for each performances for all
        $query = $em->createQuery("SELECT COUNT(t.title) as nb, t.title as title FROM AppBundle:Number n JOIN n.performance_thesaurus t GROUP BY t.title ORDER BY t.title ASC");
        $query->setMaxResults($max);
        $performances = $query->getResult();

        $query = $em->createQuery("SELECT t.title as title FROM AppBundle:Number n JOIN n.performance_thesaurus t GROUP BY t.title ORDER BY t.title ASC");
        $performances_title = $query->getResult();

        //new array for collecting all the value of diegetic even when 0
        $performance_format = [];

        $i = 0;
        foreach ($performances_title as $item) {

//            dump($item['title']);die;

            $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n LEFT JOIN n.performance_thesaurus t JOIN n.performers p  WHERE p.personId = :person AND t.title = :title ORDER BY t.title ASC");
            $query->setParameter('person', $personId );
            $query->setParameter('title', $item['title']);
            $selectPerformance = $query->getResult();

            $selectPerformance['title'] = $item['title'];
            $selectPerformance['nb'] = $selectPerformance[0]['nb'];
            unset($selectPerformance[0]); //for cleaning the array (juste two rows)

//                        dump($selectPerformance['title']);die;

            $performance_format[$i]['title'] = $selectPerformance['title'];
            $performance_format[$i]['nb']= $selectPerformance['nb'];
            $i++;

        }

//        dump($performance_format);die;

        //total of numbers with a performance
        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.performance_thesaurus t ");
        $totalNumbers = $query->getSingleResult();
//
        //total of numbers with a performance for the person
        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.performance_thesaurus t JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId );
        $totalNumbersForPerson = $query->getSingleResult();

        $performancesArray = array();
        for ($i = 0; $i < count($performance_format); $i++) {

            if (count($performance_format) == count($performances)){

                //ajouter une condition si est nul
                $requete = $performances[$i]['title'];
                $requete4 = $performance_format[$i]['title'];

                if(!ISSET($performance_format[$i]['nb'])){
                    $requete2 = 0;
                }
                else{
                    $requete2 = $performance_format[$i]['nb'];
                }
                $requete3 = $performances[$i]['nb'];

                $key = $i;

                $performancesArray[$key]['label'] = $requete;
                $performancesArray[$key]['label'] = $requete4;
                $performancesArray[$key]['one_item'] = round((intval($requete2) / intval($totalNumbersForPerson['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
                $performancesArray[$key]['all_items'] = round((intval($requete3) / intval($totalNumbers['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
            }

        }

//        dump($performancesArray);die;
        return new JsonResponse($performancesArray);
    }

    /**
     * @Route("/melviz/structure/{personId}", name="api_person_melviz_structure")
     */
    public function getMelvizStructure($personId)
    {
        $em = $this->getDoctrine()->getManager();

        //total performances for each performances for one person
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title as title FROM AppBundle:Number n LEFT JOIN n.structure t JOIN n.performers p  WHERE p.personId = :person GROUP BY t.title ORDER BY t.title ASC");
        $query->setParameter('person', $personId );
        $structure = $query->getResult();

        $max = count($structure);
        $max = 9;

        //total performances for each performances for all
        $query = $em->createQuery("SELECT COUNT(t.title) as nb, t.title as title FROM AppBundle:Number n JOIN n.structure t GROUP BY t.title ORDER BY t.title ASC");
        $query->setMaxResults($max);
        $structures = $query->getResult();

        $query = $em->createQuery("SELECT t.title as title FROM AppBundle:Number n JOIN n.structure t GROUP BY t.title ORDER BY t.title ASC");
        $structures_title = $query->getResult();

        //new array for collecting all the value of diegetic even when 0
        $structure_format = [];

        $i = 0;
        foreach ($structures_title as $item) {

//            dump($item['title']);die;

            $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n LEFT JOIN n.structure t JOIN n.performers p  WHERE p.personId = :person AND t.title = :title ORDER BY t.title ASC");
            $query->setParameter('person', $personId );
            $query->setParameter('title', $item['title']);
            $selectStructure = $query->getResult();

            $selectStructure['title'] = $item['title'];
            $selectStructure['nb'] = $selectStructure[0]['nb'];
            unset($selectStructure[0]); //for cleaning the array (juste two rows)

//                        dump($selectPerformance['title']);die;

            $structure_format[$i]['title'] = $selectStructure['title'];
            $structure_format[$i]['nb']= $selectStructure['nb'];
            $i++;

        }

//        dump($performance_format);die;

        //total of numbers with a performance
        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.structure t ");
        $totalNumbers = $query->getSingleResult();
//
        //total of numbers with a performance for the person
        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.structure t JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId );
        $totalNumbersForPerson = $query->getSingleResult();

        $structuresArray = array();
        for ($i = 0; $i < count($structure_format); $i++) {

            if (count($structure_format) == count($structures)){

                //ajouter une condition si est nul
                $requete = $structures[$i]['title'];
                $requete4 = $structure_format[$i]['title'];

                if(!ISSET($structure_format[$i]['nb'])){
                    $requete2 = 0;
                }
                else{
                    $requete2 = $structure_format[$i]['nb'];
                }
                $requete3 = $structures[$i]['nb'];

                $key = $i;

                $structuresArray[$key]['label'] = $requete;
                $structuresArray[$key]['label'] = $requete4;
                $structuresArray[$key]['one_item'] = round((intval($requete2) / intval($totalNumbersForPerson['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
                $structuresArray[$key]['all_items'] = round((intval($requete3) / intval($totalNumbers['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
            }

        }

//        dump($performancesArray);die;
        return new JsonResponse($structuresArray);
    }


//  Completeness

    /**
     * @Route("/melviz/completeness/{personId}", name="api_person_melviz_completeness")
     */
    public function getMelvizCompleteness($personId)
    {
        $em = $this->getDoctrine()->getManager();

        //total performances for each performances for one person
        $query = $em->createQuery("SELECT COUNT(n) as nb, t.title as title FROM AppBundle:Number n LEFT JOIN n.completenessThesaurus t JOIN n.performers p  WHERE p.personId = :person GROUP BY t.title ORDER BY t.title ASC");
        $query->setParameter('person', $personId );
        $structure = $query->getResult();

        $max = count($structure);
        $max = 9;

        //total performances for each performances for all
        $query = $em->createQuery("SELECT COUNT(t.title) as nb, t.title as title FROM AppBundle:Number n JOIN n.completenessThesaurus t GROUP BY t.title ORDER BY t.title ASC");
        $query->setMaxResults($max);
        $structures = $query->getResult();

        $query = $em->createQuery("SELECT t.title as title FROM AppBundle:Number n JOIN n.completenessThesaurus t GROUP BY t.title ORDER BY t.title ASC");
        $structures_title = $query->getResult();

        //new array for collecting all the value of diegetic even when 0
        $structure_format = [];

        $i = 0;
        foreach ($structures_title as $item) {

//            dump($item['title']);die;

            $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n LEFT JOIN n.completenessThesaurus t JOIN n.performers p  WHERE p.personId = :person AND t.title = :title ORDER BY t.title ASC");
            $query->setParameter('person', $personId );
            $query->setParameter('title', $item['title']);
            $selectStructure = $query->getResult();

            $selectStructure['title'] = $item['title'];
            $selectStructure['nb'] = $selectStructure[0]['nb'];
            unset($selectStructure[0]); //for cleaning the array (juste two rows)

//                        dump($selectPerformance['title']);die;

            $structure_format[$i]['title'] = $selectStructure['title'];
            $structure_format[$i]['nb']= $selectStructure['nb'];
            $i++;

        }

//        dump($performance_format);die;

        //total of numbers with a performance
        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.completenessThesaurus t ");
        $totalNumbers = $query->getSingleResult();
//
        //total of numbers with a performance for the person
        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.completenessThesaurus t JOIN n.performers p WHERE p.personId = :person");
        $query->setParameter('person', $personId );
        $totalNumbersForPerson = $query->getSingleResult();

        $structuresArray = array();
        for ($i = 0; $i < count($structure_format); $i++) {

            if (count($structure_format) == count($structures)){

                //ajouter une condition si est nul
                $requete = $structures[$i]['title'];
                $requete4 = $structure_format[$i]['title'];

                if(!ISSET($structure_format[$i]['nb'])){
                    $requete2 = 0;
                }
                else{
                    $requete2 = $structure_format[$i]['nb'];
                }
                $requete3 = $structures[$i]['nb'];

                $key = $i;

                $structuresArray[$key]['label'] = $requete;
                $structuresArray[$key]['label'] = $requete4;
                $structuresArray[$key]['one_item'] = round((intval($requete2) / intval($totalNumbersForPerson['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
                $structuresArray[$key]['all_items'] = round((intval($requete3) / intval($totalNumbers['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
            }

        }

//        dump($performancesArray);die;
        return new JsonResponse($structuresArray);
    }

}