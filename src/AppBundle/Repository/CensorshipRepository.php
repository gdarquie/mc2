<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CensorshipRepository extends EntityRepository
{
    public function findAllOrderdByTitle()
    {
        return $this->createQueryBuilder('censorship')
            ->orderBy('censorship.title', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function createAlphabeticalQueryBuilder()
    {

        return $this->createQueryBuilder('censorship')
            ->orderBy('censorship.title', 'ASC');

    }

}



