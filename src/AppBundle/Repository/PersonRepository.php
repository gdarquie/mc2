<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PersonRepository extends EntityRepository
{
    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('person')
            ->orderBy('person.name', 'ASC');
    }
}

