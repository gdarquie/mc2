<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StagenumberRepository extends EntityRepository
{
    public function findAllOrderdByTitleWhereSelected()
    {

        return $this->createQueryBuilder('stagenumber')
            ->where('stagenumber.selected = :selected')
            ->setParameter('selected', 'true')
            ->orderBy('stagenumber.title', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->execute();
    }

    public function createAlphabeticalQueryBuilder()
    {

        return $this->createQueryBuilder('stagenumber')
            ->where('stagenumber.selected = :selected')
            ->setParameter('selected', true)
            ->orderBy('stagenumber.title', 'ASC')
            ->setMaxResults(2500);
    }

}





