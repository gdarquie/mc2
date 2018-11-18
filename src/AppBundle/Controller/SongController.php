<?php

namespace AppBundle\Controller;

use Elastica\Query;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SongController extends BaseController
{
    const SONG = 'song';

    /**
     * @Route("song/id/{songId}", name="song")
     */
    public function songAction($songId){


        $handler = $this->getHandler(SongController::SONG);
        $data = $handler->getSong($songId);

        //test ES
//        $finder = $this->container->get('fos_elastica.finder.mc2.number');
//
//        $boolQuery = new Query\BoolQuery();
//        $tagsQuery = new Query\Terms();
//        $tagsQuery->setTerms('title', array('Put Me to the Test'));
//        $boolQuery->addShould($tagsQuery);
//
//        $data = $finder->find($boolQuery);

//        dump($data);die;


        return $this->render('AppBundle:song:song.html.twig',array(
            'song' => $data['song'],
            'films' => $data['films'],
            'numbers' => $data['numbers']
        ));
    }



}
