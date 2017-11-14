<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SongRepository extends EntityRepository
{
    public function findAllOrderdByTitle()
    {
        return $this->createQueryBuilder('song')
            ->orderBy('song.title', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('song')
            ->orderBy('song.title', 'ASC');

    }

}



