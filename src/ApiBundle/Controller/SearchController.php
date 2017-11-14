<?php
//
//namespace ApiBundle\Controller;
//
//
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Symfony\Component\HttpFoundation\JsonResponse;
//
//
//class SearchController extends Controller
//{
//    /**
//     * @Route("api/search")
//     */
//    public function indexAction()
//    {
//        $em = $this->getDoctrine()->getManager();
////        $numbers = $em->getRepository('AppBundle:Number')->findAll();
//        $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.source_thesaurus t WHERE n.performance_thesaurus IS NOT NULL OR t.title IS NOT NULL");
////        $query->setMaxResults(100);
//        $numbers = $query->getResult();
//
//        $query = $em->createQuery("SELECT DISTINCT(t.title) as title FROM AppBundle:Thesaurus t WHERE t.type = :source");
//        $query->setParameter('source', 'source');
//        $sources = $query->getResult();
//
//        $query = $em->createQuery("SELECT DISTINCT(t.title) as title FROM AppBundle:Thesaurus t WHERE t.type = :performance_thesaurus");
//        $query->setParameter('performance_thesaurus', 'performance_thesaurus');
//        $performance_thesaurus = $query->getResult();
//
//
//        return $this->render('ApiBundle:search:index.html.twig', array(
//            'numbers' => $numbers,
//            'sources' => $sources,
//            'performances' => $performance_thesaurus
//        ));
//
//    }
//
//    /**
//     * @Route("api/search/dance")
//     */
//    public function searchDanceAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $min = 2;
//
//        //List of songId used by at least $min distinct films
//        $query = $em->createQuery("SELECT s.songId as songId FROM AppBundle:Song s JOIN s.number n JOIN n.film f GROUP BY s.songId HAVING COUNT(DISTINCT(f.filmId))  >= :min ");
//        $query->setParameter('min', $min );
//        $songIdWithMultipleFilms = $query->getResult();
//
//        //Numbers of Films with songs connected to 2 or more film with performance_thesaurus = "intrumental+dance" OR "song+dance"
//        $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.film f JOIN n.song s  WHERE (s.songId IN(:songs) AND (n.performance_thesaurus = :perf1 OR n.performance_thesaurus = :perf2)) GROUP BY n.id");
//        $query->setParameter('songs', $songIdWithMultipleFilms );
//        $query->setParameter('perf1', "intrumental+dance" );
//        $query->setParameter('perf2', "song+dance" );
//        $numbers = $query->getResult();
//
//        $query = $em->createQuery("SELECT DISTINCT(t.title) as title FROM AppBundle:Thesaurus t WHERE t.type = :source");
//        $query->setParameter('source', 'source');
//        $sources = $query->getResult();
//
//        $query = $em->createQuery("SELECT DISTINCT(t.title) as title FROM AppBundle:Thesaurus t WHERE t.type = :performance_thesaurus");
//        $query->setParameter('performance_thesaurus', 'performance');
//        $performance_thesaurus = $query->getResult();
//
//
//        return $this->render('ApiBundle:search:index.html.twig', array(
//            'numbers' => $numbers,
//            'sources' => $sources,
//            'performances' => $performance_thesaurus
//        ));
//
//    }
//
//    /**
//     * @Route("api/search/dance/type={type}/category={category}/title={title}")
//     */
//    public function danceAction($type,$title,$category){
//
//        $em = $this->getDoctrine()->getManager();
//
//        //Tests
////        $type = "Dance";
////        $title = "tap dance";
////        $category = "Dancing type";
//        //end test
//
//
////        $query = $em->createQuery("SELECT t.title as title, COUNT(t.id) as nb, SUM(t.id) as total FROM AppBundle:Number n JOIN n.dancingType t WHERE t.type = :type AND t.category = :category GROUP BY t.id ");
////        $query->setParameter('type', $type);
////        $query->setParameter('category', $category);
////        $dancingtypes = $query->getResult();
//
////        dump($dancingtypes);die;
//
//        if ($type == "Dance"){
//            if($category == 'Dancing type'){
//                $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.dancingType t WHERE t.type = :type AND t.title = :title AND t.category = :category");
//            }
//            else if($category == 'Dance sub-genre'){
//                $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.danceSubgenre t WHERE t.type = :type AND t.title = :title AND t.category = :category");
//            }
//            else if($category == 'Dance content') {
//                $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.danceContent t WHERE t.type = :type AND t.title = :title AND t.category = :category");
//            }
//        }
//        else if($type == 'dancEmble')
//            $query = $em->createQuery("SELECT COUNT(n.id) as nb FROM AppBundle:Number n JOIN n.dancemble t WHERE t.type = :type AND t.title = :title AND t.category = :category");
//
//        $query->setParameter('type', $type);
//        $query->setParameter('title', $title);
//        $query->setParameter('category', $category);
//        $dances = $query->getResult();
//
//        $response = new JsonResponse($dances, 200);
//
//        return $response;
//
//    }
//
//    /**
//     * @Route("api/search/exoticism={exoticisms}/studio={studio}/period={begin}-{end}", name="search_exoticism")
//     */
//    public function searchExoticismAction($exoticisms, $studio, $begin, $end)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        if($exoticisms == 'all'){
//            $exoticisms = '%';
//        }
//        if($studio == 'all'){
//            $studio = '%';
//        }
//
//        if($begin == 0){
//            //select first date
//            $begin = 1900;
//        }
//        if($end == 0){
//            //select last date
//            $end = 2000;
//        }
//
//        $query = $em->createQuery("SELECT n FROM AppBundle:Number n JOIN n.exoticism_thesaurus e JOIN n.film f JOIN f.studios s WHERE e.id LIKE :exoticisms AND s.studioId LIKE :studio AND f.released > :begin AND f.released < :end");
//        $query->setParameter('exoticisms', $exoticisms);
//        $query->setParameter('studio', $studio);
//        $query->setParameter('begin', $begin);
//        $query->setParameter('end', $end);
//        $numbers = $query->getResult();
//
//        return $this->render('ApiBundle:search:exoticism.html.twig', array(
//            'numbers' => $numbers
//        ));
//
//    }
//
//    /**
//     * @Route("api/search/all/period={begin}-{end}", name="search_exoticism_test")
//     */
//    public function searchAllAction($exoticisms, $studio, $begin, $end)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        if($begin == 0){
//            //select first date
//            $begin = 1900;
//        }
//        if($end == 0){
//            //select last date
//            $end = 2000;
//        }
//
//        $query = $em->createQuery("SELECT COUNT(n) as nb FROM AppBundle:Number n");
////        $query->setParameter('begin', $begin);
////        $query->setParameter('end', $end);
//        $numbers = $query->getResult();
//
//
//        return $this->render('ApiBundle:search:all.html.twig', array(
//            'numbers' => $numbers
//        ));
//
//    }
//
//}
