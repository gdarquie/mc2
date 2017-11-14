<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Song;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("api/songs")
 */
class SongController extends Controller
{

    /**
     * @Route("/")
     */
    public function songsByAction(){

        //retourner les titres de tous les films par ordre alphabétique

        $em = $this->getDoctrine()->getManager();
        $songs = $em->getRepository('AppBundle:Song')->findAll();
        $data = array('song' => array());
        foreach ($songs as $song) {
            $data['song'][] = $this->serializeSong($song);
        }

        $response = new JsonResponse($data, 200);

        return $response;
    }

    private function serializeSong(Song $song)
    {
        return array(
            'songId' => $song->getSongId(),
            'title' => $song->getTitle(),
        );
    }

}
