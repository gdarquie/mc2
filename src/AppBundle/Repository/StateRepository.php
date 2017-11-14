<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StateRepository extends EntityRepository
{
    public function findAllOrderdByTitle()
    {
        return $this->createQueryBuilder('state')
            ->orderBy('state.title', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function createAlphabeticalQueryBuilder()
    {

        return $this->createQueryBuilder('state')
            ->orderBy('state.title', 'ASC');

    }

}



