<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Person;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("api/censorship")
 */
class CensorshipController extends Controller
{


    /**
     * @Route("/melviz/studios_verdict/{verdict}", name="api_censorship_melviz_studios_verdict")
     */
    public function getMelvizStudiosVerdict($verdict)
    {
        $em = $this->getDoctrine()->getManager();

        //average
        $query = $em -> createQuery('SELECT count(f) FROM AppBundle:Film f WHERE f.verdict = :verdict');
        $query->setParameter('verdict', $verdict);
        $nbFilmsWithOneVerdict = $query->getSingleResult();

        $query = $em -> createQuery('SELECT count(f.filmId) FROM AppBundle:Film f WHERE f.verdict != :null');
        $query->setParameter('null', '');
        $nbFilmsWithVerdict = $query->getSingleResult();

        $average = round((intval($nbFilmsWithOneVerdict[1]) / intval($nbFilmsWithVerdict[1])) * 100, 1, PHP_ROUND_HALF_UP);


        $studiosArray = array();

        $studiosArray[0] = $this->oneStudio($em, "Columbia",213, $verdict, $average);
        $studiosArray[1] = $this->oneStudio($em, "MGM", 205, $verdict, $average);
        $studiosArray[2] = $this->oneStudio($em, "Paramount", 209, $verdict, $average);
        $studiosArray[3] = $this->oneStudio($em, "20th Century-Fox", 243, $verdict, $average);
        $studiosArray[4] = $this->oneStudio($em, "Warner Bros.", 203, $verdict, $average);
        $studiosArray[5] = $this->oneStudio($em, "RKO", 204, $verdict, $average);
        $studiosArray[6] = $this->oneStudio($em, "Universal", 223, $verdict,$average);

        //distributor
        $query = $em -> createQuery('SELECT count(f) FROM AppBundle:Film f JOIN f.distributors d WHERE d.distributorId = :idDistributor AND f.verdict = :verdict');
        $query->setParameter('idDistributor', 2);
        $query->setParameter('verdict', $verdict);
        $nbFilmsWithOneVerdict = $query->getSingleResult();

        $query = $em -> createQuery('SELECT count(f.filmId) FROM AppBundle:Film f JOIN f.distributors d WHERE d.distributorId = :idDistributor AND f.verdict != :null');
        $query->setParameter('idDistributor', 2);
        $query->setParameter('null', '');
        $nbFilmsWithVerdict = $query->getSingleResult();

        $one_item = round((intval($nbFilmsWithOneVerdict[1]) / intval($nbFilmsWithVerdict[1])) * 100, 1, PHP_ROUND_HALF_UP);


        $studiosArray[7]['label'] = "United Artists";
        $studiosArray[7]['one_item'] = $one_item;
        $studiosArray[7]['all_items'] = $average;



        return new JsonResponse($studiosArray);
    }

    public function oneStudio($em, $studioName, $idStudio, $verdict, $average)
    {

        $query = $em -> createQuery('SELECT count(f) FROM AppBundle:Film f JOIN f.studios s WHERE s.studioId = :idStudio AND f.verdict = :verdict');
        $query->setParameter('idStudio', $idStudio);
        $query->setParameter('verdict', $verdict);
        $nbFilmsWithOneVerdict = $query->getSingleResult();

        $query = $em -> createQuery('SELECT count(f.filmId) FROM AppBundle:Film f JOIN f.studios s WHERE s.studioId = :idStudio AND f.verdict != :null');
        $query->setParameter('idStudio', $idStudio);
        $query->setParameter('null', '');
        $nbFilmsWithVerdict = $query->getSingleResult();

        $one_item = round((intval($nbFilmsWithOneVerdict[1]) / intval($nbFilmsWithVerdict[1])) * 100, 1, PHP_ROUND_HALF_UP);


        $array['label'] = $studioName;
        $array['one_item'] = $one_item;
        $array['all_items'] = $average;

        return $array;
    }
}