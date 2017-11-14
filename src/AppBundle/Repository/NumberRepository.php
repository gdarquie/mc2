<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class NumberRepository extends EntityRepository
{
    public function findAllOrderdByTitle()
    {
        return $this->createQueryBuilder('number')
            ->orderBy('number.title', 'ASC')
            ->getQuery()
            ->execute();
    }
}





