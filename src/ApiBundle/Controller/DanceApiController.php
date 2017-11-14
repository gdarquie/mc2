<?php
//
//namespace ApiBundle\Controller;
//
//use AppBundle\Entity\Thesaurus;
//
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\JsonResponse;
//
//
///**
// * @Route("api/dances")
// */
//class DanceApiController extends Controller
//{
//
//    /**
//     * @Route("/dancing-type/")
//     */
//    public function dancingTypeAction(){
//
//        //retourner les titres de tous les films par ordre alphabétique
//
//        $em = $this->getDoctrine()->getManager();
//        $query = $em->createQuery('SELECT d FROM AppBundle:Thesaurus d WHERE d.type = :dance AND d.category = :category');
//        $query->setParameter('dance', "dance");
//        $query->setParameter('category', "Dancing type");
//        $dances = $query->getResult();
//
////        $dances = $em->getRepository('AppBundle:Thesaurus')->findAll();
//
//
//        $data = array('dance' => array());
//        foreach ($dances as $dance) {
//            $data['dance'][] = $this->serializedance($dance);
//        }
//
//        $response = new JsonResponse($data, 200);
//
//        return $response;
//    }
//
//    private function serializedance(Thesaurus $dance)
//    {
//        return array(
//            'danceId' => $dance->getId(),
//            'title' => $dance->getTitle(),
//            'category' => $dance->getCategory(),
//        );
//    }
//
//}
