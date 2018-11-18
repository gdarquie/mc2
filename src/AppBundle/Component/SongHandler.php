<?php

namespace AppBundle\Component;

class SongHandler extends BaseHandler
{
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
}