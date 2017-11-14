<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StageshowRepository extends EntityRepository
{
    public function findAllOrderdByTitle()
    {

        return $this->createQueryBuilder('stageshow')
            ->orderBy('stageshow.title', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function createAlphabeticalQueryBuilder()
    {

        return $this->createQueryBuilder('stageshow')
            ->orderBy('stageshow.title', 'ASC');

    }

}



