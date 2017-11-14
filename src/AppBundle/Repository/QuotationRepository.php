<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class QuotationRepository extends EntityRepository
{
	public function findAllOrderdByTitle()
	    {
	        return $this->createQueryBuilder('quotation')
	            ->orderBy('quotation.title', 'ASC')
	            ->getQuery()
            	->execute();
	    }

	public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('quotation')
       		->where('quotation.title != :identifier')
            ->orderBy('quotation.title', 'ASC')
            ->setParameter('identifier', '');
    }

}



