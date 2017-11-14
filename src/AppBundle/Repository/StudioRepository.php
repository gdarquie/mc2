<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StudioRepository extends EntityRepository
{
    public function findAllOrderdByTitle()
    {
        return $this->createQueryBuilder('studio')
            ->orderBy('studio.title', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function createAlphabeticalQueryBuilder()
    {

        return $this->createQueryBuilder('studio')
            ->orderBy('studio.title', 'ASC');

    }

}



