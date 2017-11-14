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
        $song = $em->getRepository('AppBundle:Song')->findOneBySongId($songId);

        $query = $em->createQuery("SELECT DISTINCT(f.title) as title, f.filmId as filmId, f.idImdb as imdb FROM AppBundle:Song s LEFT JOIN s.number n JOIN n.film f WHERE s.songId = :songId");
        $query->setParameter('songId', $songId );
        $films = $query->getResult();


        return $this->render('AppBundle:song:song.html.twig',array(
            'song' => $song,
            'films' => $films
        ));
    }



}
