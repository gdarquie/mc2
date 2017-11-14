<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FilmRepository extends EntityRepository
{
	public function findAllOrderdByTitle()
	    {
	        return $this->createQueryBuilder('film')
	            ->orderBy('film.title', 'ASC')
	            ->getQuery()
            	->execute();
	    }

	public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('film')
            ->orderBy('film.title', 'ASC');
 
    }

    public function findFilmNumber($filmId){
        return $this->createQueryBuilder('film')
            ->where('film.filmId = :filmId')
            ->setParameters(array( 'filmId' => $filmId));
    }

}



