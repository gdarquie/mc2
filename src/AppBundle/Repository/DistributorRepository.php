<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DistributorRepository extends EntityRepository
{
    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('distributor')
            ->orderBy('distributor.title', 'ASC');
    }
}

