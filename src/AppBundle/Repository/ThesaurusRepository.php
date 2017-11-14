<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ThesaurusRepository extends EntityRepository
{
    //return query builder
	public function findAllOrderdByTitle()
    {
        return $this->createQueryBuilder('thesaurus')
            ->orderBy('thesaurus.title', 'ASC')
            ->getQuery()
        	->execute();
    }

    //return query builder
	public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('thesaurus')
            ->orderBy('thesaurus.title', 'ASC');
 
    }

    //return query builder
    public function findAllThesaurusByCode($code)
    {

        $qb = $this->createQueryBuilder('thesaurus')
            ->join('thesaurus.code', 'c')
            ->where('c.content = :code')
            ->orderBy('thesaurus.title', 'ASC')
            ->setParameter('code', $code);

        return $qb;
    }


//    public function findNumbersById($thesaurusId, $code){
//        return $this->getEntityManager('SELECT t FOM AppBundle:Thesaurus t JOIN t.'.$code.' WHERE t.id = :id')->createQuery("")
//            ->setParameter('id', $id)
//            ->getResult();
//    }



}



