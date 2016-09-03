<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ThesaurusRepository extends EntityRepository
{
	public function findAllOrderdByTitle()
    {
        return $this->createQueryBuilder('thesaurus')
            ->orderBy('thesaurus.title', 'ASC')
            ->getQuery()
        	->execute();
    }

	public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('thesaurus')
            ->orderBy('thesaurus.title', 'ASC');
 
    }

    public function findAllBegin()
    {
	        return $this->createQueryBuilder('thesaurus')
	        	->where('thesaurus.type = :type')
	            ->orderBy('thesaurus.title', 'ASC')
	            ->setParameter('type', 'begin');
    }

    public function findAllEnding()
    {
	        return $this->createQueryBuilder('thesaurus')
	        	->where('thesaurus.type = :type')
	            ->orderBy('thesaurus.title', 'ASC')
	            ->setParameter('type', 'ending');
    }
}



