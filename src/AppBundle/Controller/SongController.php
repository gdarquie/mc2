<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class SongController extends BaseController
{
    const SONG = 'song';

    /**
     * @Route("song/id/{songId}", name="song")
     */
    public function getSong($songId){

        $handler = $this->getHandler(SongController::SONG);
        $data = $handler->getSong($songId);

        return $this->render('AppBundle:song:song.html.twig',array(
            'song' => $data['song'],
            'films' => $data['films'],
            'numbers' => $data['numbers']
        ));
    }

    /**
     * @Route("song/es/{songId}", name="song_elastic")
     */
    public function testElasticSearch($songId)
    {
        $handler = $this->getHandler(SongController::SONG);
        $finder = $this->container->get('fos_elastica.finder.mc2.number');
        $data = $handler->getFilms($finder, $songId);

        return new JsonResponse($data);
    }


}
