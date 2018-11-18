<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SongController extends Controller
{
    /**
     * @Route("song/id/{songId}", name="song")
     */
    public function songAction($songId){

        $em = $this->getDoctrine()->getManager();
        $song = $em->getRepository('AppBundle:Song')
            ->findOneBySongId($songId);

        $films = $em->getRepository('AppBundle:Song')->getFilmsOrderByReleased($songId)
            ->getQuery()
            ->execute();

        $numbers = $em->getRepository('AppBundle:Song')->getNumbersOrderByReleased($songId)
            ->getQuery()
            ->execute();

        return $this->render('AppBundle:song:song.html.twig',array(
            'song' => $song,
            'films' => $films,
            'numbers' => $numbers
        ));
    }



}
