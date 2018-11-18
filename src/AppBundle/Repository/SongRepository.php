<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SongRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function findAllOrderdByTitle()
    {
        return $this->createQueryBuilder('song')
            ->orderBy('song.title', 'ASC')
            ->getQuery()
            ->execute();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('song')
            ->orderBy('song.title', 'ASC');

    }

    /**
     * @param $songId
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getFilmsOrderByReleased($songId)
    {
        return $this->createQueryBuilder('s')
            ->select('DISTINCT(f.title) as title, f.filmId as filmId, f.idImdb as imdb, f.released as released')
            ->leftJoin('s.number', 'n')
            ->innerJoin('n.film', 'f')
            ->where('s.songId = :songId')
            ->orderBy('f.released')
            ->setParameter('songId', $songId)
            ;
    }

    /**
     * @param $songId
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getNumbersOrderByReleased($songId)
    {
        return $this->createQueryBuilder('s')
        ->select('n.id, n.title, f.idImdb as imdb, f.released')
        ->leftJoin('s.number', 'n')
        ->innerJoin('n.film', 'f')
        ->where('s.songId = :songId')
        ->orderBy('f.released, f.filmId, n.beginTc')
        ->setParameter('songId', $songId)
            ;
    }

}



