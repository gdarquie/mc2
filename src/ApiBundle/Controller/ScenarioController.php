<?php
//
//namespace ApiBundle\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\JsonResponse;
//
//
///**
// * @Route("api/scenario")
// */
//class ScenarioController extends Controller
//{
//
//    /**
//     * @Route("/marion/quotation", name="api_marion_quotation")
//     */
//    public function marionquotationAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//        $query = $em->createQuery('SELECT n.id as id, n.title as title FROM AppBundle:Number n JOIN n.quotation q WHERE q.title IS NOT NULL');
//        $numbers = $query->getResult();
//
//        $response = new JsonResponse($numbers, 200);
//
//        return $response;
//    }
//
//
//    /**
//     * @Route("/melviz/dancetype", name="api_person_melviz_dancetype")
//     */
//    // Melviz Dance Type
//    public function getMelvizDancetype(){
//
//        $em = $this->getDoctrine()->getManager();
//
//        $min = 2;
//
////        List of songId used by at least $min distinct films
//        $query = $em->createQuery("SELECT s.songId as songId FROM AppBundle:Song s JOIN s.number n JOIN n.film f GROUP BY s.songId HAVING COUNT(DISTINCT(f.filmId))  >= :min ");
//        $query->setParameter('min', $min );
//        $songIdWithMultipleFilms = $query->getResult();
//
////      Our selection of numbers
//        $query = $em->createQuery("SELECT n.id as id FROM AppBundle:Number n JOIN n.film f JOIN n.song s  WHERE (s.songId IN(:songs) AND (n.performance_thesaurus = :perf1 OR n.performance_thesaurus = :perf2)) GROUP BY n.id");
//        $query->setParameter('songs', $songIdWithMultipleFilms );
//        $query->setParameter('perf1', 183 );
//        $query->setParameter('perf2', 186 );
//        $numbers = $query->getResult();
//
////        dump($numbers);die();
//
//        //number of numbers per dancing type for the selection
//        $query = $em->createQuery("SELECT t.title as title, COUNT(t.id) as nb FROM AppBundle:Number n JOIN n.dancingType t  WHERE n.id IN(:numbers)GROUP BY t.id  ");
//        $query->setParameter('numbers', $numbers );
//        $one = $query->getResult();
//
//        //number of numbers per dancing type for all
//        $query = $em->createQuery("SELECT t.title as title, COUNT(t.id) as nb FROM AppBundle:Number n JOIN n.dancingType t GROUP BY t.id ORDER BY t.title");
//        $all = $query->getResult();
//
//        $query = $em->createQuery("SELECT t.title as title FROM AppBundle:Number n JOIN n.dancingType t GROUP BY t.id ORDER BY t.title ASC");
//        $titles = $query->getResult();
//
//        $max = count($all);
//        $formating = [];
//
//        $i = 0;
//        foreach ($titles as $item) {
//
////            dump($item['title']);die;
//
//            $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n LEFT JOIN n.dancingType t WHERE t.title = :title AND n.id IN(:numbers) ORDER BY t.title ASC");
//            $query->setParameter('numbers', $numbers);
//            $query->setParameter('title', $item['title']);
//            $temp = $query->getResult();
//
//            $temp['title'] = $item['title'];
//            $temp['nb'] = $temp[0]['nb'];
//            unset($temp[0]); //for cleaning the array (juste two rows)
//
////                        dump($formating['title']);die;
//
//            $formating[$i]['title'] = $temp['title'];
//            $formating[$i]['nb']= $temp['nb'];
//            $i++;
//
//        }
//
////        dump($formating);die;
//
//
//        //total of numbers for all
//        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.dancingType t ");
//        $totalNumbers = $query->getSingleResult();
//
////        dump($totalNumbers);die();
//
//        //total of numbers for selection
//        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.dancingType t  WHERE n.id IN(:numbers)");
//        $query->setParameter('numbers', $numbers);
//        $totalNumbersForSelection = $query->getSingleResult();
//
////        dump($totalNumbersForSelection);die();
//
//        $final = array();
//
//        for ($i = 0; $i < count($formating); $i++) {
//
//            if (count($formating) == count($all)) {
//
//                //ajouter une condition si est nul
//                $requete = $all[$i]['title'];
//                $requete4 = $formating[$i]['title'];
//
//
//                if (!ISSET($formating[$i]['nb'])) {
//                    $requete2 = 0;
//                } else {
//                    $requete2 = $formating[$i]['nb'];
//                }
//                $requete3 = $all[$i]['nb'];
//                }
//                $key = $i;
//
//                $final[$key]['label'] = $requete;
//                $final[$key]['label'] = $requete4;
//                $final[$key]['one_item'] = round((intval($requete2) / intval($totalNumbersForSelection['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
//                $final[$key]['all_items'] = round((intval($requete3) / intval($totalNumbers['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
//
//
//            if($final[$key]['label'] == "NA"){
//                unset($final[$key]);
//            }
//
//        }
//
//
//        $final = array_values($final);
////        dump($final);die;
//
//
//        return new JsonResponse($final);
//
//    }
//
//    // Melviz Subgenre
//
//    /**
//     * @Route("/melviz/dancesubgenre", name="api_person_melviz_dancesubgenre")
//     */
//    // Melviz Dance Type
//    public function getMelvizDancesubgenre(){
//
//        $em = $this->getDoctrine()->getManager();
//
//        $min = 2;
//
////        List of songId used by at least $min distinct films
//        $query = $em->createQuery("SELECT s.songId as songId FROM AppBundle:Song s JOIN s.number n JOIN n.film f GROUP BY s.songId HAVING COUNT(DISTINCT(f.filmId))  >= :min ");
//        $query->setParameter('min', $min );
//        $songIdWithMultipleFilms = $query->getResult();
//
////      Our selection of numbers
//        $query = $em->createQuery("SELECT n.id as id FROM AppBundle:Number n JOIN n.film f JOIN n.song s  WHERE (s.songId IN(:songs) AND (n.performance_thesaurus = :perf1 OR n.performance_thesaurus = :perf2)) GROUP BY n.id");
//        $query->setParameter('songs', $songIdWithMultipleFilms );
//        $query->setParameter('perf1', 183 );
//        $query->setParameter('perf2', 186 );
//        $numbers = $query->getResult();
//
//        //number of numbers per dancing type for the selection
//        $query = $em->createQuery("SELECT t.title as title, COUNT(t.id) as nb FROM AppBundle:Number n JOIN n.danceSubgenre t  WHERE n.id IN(:numbers)GROUP BY t.id  ");
//        $query->setParameter('numbers', $numbers );
//        $one = $query->getResult();
//
//        //number of numbers per dancing type for all
//        $query = $em->createQuery("SELECT t.title as title, COUNT(t.id) as nb FROM AppBundle:Number n JOIN n.danceSubgenre t GROUP BY t.id ORDER BY t.title");
//        $all = $query->getResult();
//
//        $query = $em->createQuery("SELECT t.title as title FROM AppBundle:Number n JOIN n.danceSubgenre t GROUP BY t.id ORDER BY t.title ASC");
//        $titles = $query->getResult();
//
//        $max = count($all);
//        $formating = [];
//
//
//        $i = 0;
//        foreach ($titles as $item) {
//
////            dump($item['title']);die;
//
//            $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n LEFT JOIN n.danceSubgenre t WHERE t.title = :title AND n.id IN(:numbers) ORDER BY t.title ASC");
//            $query->setParameter('numbers', $numbers);
//            $query->setParameter('title', $item['title']);
//            $temp = $query->getResult();
//
//            $temp['title'] = $item['title'];
//            $temp['nb'] = $temp[0]['nb'];
//            unset($temp[0]); //for cleaning the array (juste two rows)
//
////                        dump($formating['title']);die;
//
//            $formating[$i]['title'] = $temp['title'];
//            $formating[$i]['nb']= $temp['nb'];
//            $i++;
//
//        }
//
////        dump($formating);die;
//
//
//        //total of numbers for all
//        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.danceSubgenre t ");
//        $totalNumbers = $query->getSingleResult();
//
////        dump($totalNumbers);die();
//
//        //total of numbers for selection
//        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.danceSubgenre t  WHERE n.id IN(:numbers)");
//        $query->setParameter('numbers', $numbers);
//        $totalNumbersForSelection = $query->getSingleResult();
//
////        dump($totalNumbersForSelection);die();
//
//        $final = array();
//        for ($i = 0; $i < count($formating); $i++) {
//
//            if (count($formating) == count($all)){
//
//                //ajouter une condition si est nul
//                $requete = $all[$i]['title'];
//                $requete4 = $formating[$i]['title'];
//
//                if(!ISSET($formating[$i]['nb'])){
//                    $requete2 = 0;
//                }
//                else{
//                    $requete2 = $formating[$i]['nb'];
//                }
//                $requete3 = $all[$i]['nb'];
//
//                $key = $i;
//
//                $final[$key]['label'] = $requete;
//                $final[$key]['label'] = $requete4;
//                $final[$key]['one_item'] = round((intval($requete2) / intval($totalNumbersForSelection['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
//                $final[$key]['all_items'] = round((intval($requete3) / intval($totalNumbers['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
//            }
//
//        }
//
////        dump($final);die;
//
//        return new JsonResponse($final);
//
//    }
//
//    // Melviz Dance content
//
//    /**
//     * @Route("/melviz/dancecontent", name="api_person_melviz_dancecontent")
//     */
//    // Melviz Dance Type
//    public function getMelvizDancecontent(){
//
//        $em = $this->getDoctrine()->getManager();
//
//        $min = 2;
//
////        List of songId used by at least $min distinct films
//        $query = $em->createQuery("SELECT s.songId as songId FROM AppBundle:Song s JOIN s.number n JOIN n.film f GROUP BY s.songId HAVING COUNT(DISTINCT(f.filmId))  >= :min ");
//        $query->setParameter('min', $min );
//        $songIdWithMultipleFilms = $query->getResult();
//
////      Our selection of numbers
//        $query = $em->createQuery("SELECT n.id as id FROM AppBundle:Number n JOIN n.film f JOIN n.song s  WHERE (s.songId IN(:songs) AND (n.performance_thesaurus = :perf1 OR n.performance_thesaurus = :perf2)) GROUP BY n.id");
//        $query->setParameter('songs', $songIdWithMultipleFilms );
//        $query->setParameter('perf1', 183 );
//        $query->setParameter('perf2', 186 );
//        $numbers = $query->getResult();
//
//        //number of numbers per dancing type for the selection
//        $query = $em->createQuery("SELECT t.title as title, COUNT(t.id) as nb FROM AppBundle:Number n JOIN n.danceContent t  WHERE n.id IN(:numbers)GROUP BY t.id  ");
//        $query->setParameter('numbers', $numbers );
//        $one = $query->getResult();
//
//        //number of numbers per dancing type for all
//        $query = $em->createQuery("SELECT t.title as title, COUNT(t.id) as nb FROM AppBundle:Number n JOIN n.danceContent t GROUP BY t.id ORDER BY t.title");
//        $all = $query->getResult();
//
//        $query = $em->createQuery("SELECT t.title as title FROM AppBundle:Number n JOIN n.danceContent t GROUP BY t.id ORDER BY t.title ASC");
//        $titles = $query->getResult();
//
//        $max = count($all);
//        $formating = [];
//
//
//        $i = 0;
//        foreach ($titles as $item) {
//
////            dump($item['title']);die;
//
//            $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n LEFT JOIN n.danceContent t WHERE t.title = :title AND n.id IN(:numbers) ORDER BY t.title ASC");
//            $query->setParameter('numbers', $numbers);
//            $query->setParameter('title', $item['title']);
//            $temp = $query->getResult();
//
//            $temp['title'] = $item['title'];
//            $temp['nb'] = $temp[0]['nb'];
//            unset($temp[0]); //for cleaning the array (juste two rows)
//
////                        dump($formating['title']);die;
//
//            $formating[$i]['title'] = $temp['title'];
//            $formating[$i]['nb']= $temp['nb'];
//            $i++;
//
//        }
//
////        dump($formating);die;
//
//
//        //total of numbers for all
//        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.danceContent t ");
//        $totalNumbers = $query->getSingleResult();
//
////        dump($totalNumbers);die();
//
//        //total of numbers for selection
//        $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.danceContent t  WHERE n.id IN(:numbers)");
//        $query->setParameter('numbers', $numbers);
//        $totalNumbersForSelection = $query->getSingleResult();
//
////        dump($totalNumbersForSelection);die();
//
//        $final = array();
//        for ($i = 0; $i < count($formating); $i++) {
//
//            if (count($formating) == count($all)){
//
//                //ajouter une condition si est nul
//                $requete = $all[$i]['title'];
//                $requete4 = $formating[$i]['title'];
//
//                if(!ISSET($formating[$i]['nb'])){
//                    $requete2 = 0;
//                }
//                else{
//                    $requete2 = $formating[$i]['nb'];
//                }
//                $requete3 = $all[$i]['nb'];
//
//                $key = $i;
//
//                $final[$key]['label'] = $requete;
//                $final[$key]['label'] = $requete4;
//                $final[$key]['one_item'] = round((intval($requete2) / intval($totalNumbersForSelection['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
//                $final[$key]['all_items'] = round((intval($requete3) / intval($totalNumbers['nb'])) * 100, 1, PHP_ROUND_HALF_UP);
//            }
//
//        }
//
////        dump($final);die;
//
//        return new JsonResponse($final);
//
//    }
//
//}
//
