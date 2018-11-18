<?php

namespace AppBundle\Component;

use Elastica\Query\BoolQuery;
use Elastica\Query\Term;

class SongHandler extends BaseHandler
{
    /**
     * @param $id
     * @return mixed
     */
    public function getSong($id)
    {
        $song = $this->em->getRepository('AppBundle:Song')
            ->findOneBySongId($id);

        $films = $this->em->getRepository('AppBundle:Song')->getFilmsOrderByReleased($id)
            ->getQuery()
            ->execute();

        $numbers = $this->em->getRepository('AppBundle:Song')->getNumbersOrderByReleased($id)
            ->getQuery()
            ->execute();

        $data['song'] = $song;
        $data['films'] = $films;
        $data['numbers'] = $numbers;

        return $data;
    }

    public function getFilms($finder, $id)
    {
        $boolQuery = new BoolQuery();
        $tagsQuery = new Term();
        $tagsQuery->setTerm('title', 'Put Me to the Test');
        $boolQuery->addShould($tagsQuery);

        $data = $finder->find($boolQuery);
        return $data;
    }
}