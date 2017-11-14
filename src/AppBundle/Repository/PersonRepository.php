<?php
/**
 * Created by PhpStorm.
 * User: gaetan
 * Date: 20/09/2016
 * Time: 12:28
 */

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


