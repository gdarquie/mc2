<?php

namespace AppBundle\Component;

use Doctrine\ORM\EntityManager;

class FilmHandler
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFilmPayload($filmId)
    {

        $payload = [];

        //film
        $query = $this->em->createQuery("SELECT f FROM AppBundle:Film f WHERE f.filmId = :film");
        $query->setParameter('film', $filmId);
        $film = $query->getSingleResult();

        //numbers
        $query = $this->em->createQuery(
            'SELECT  n FROM AppBundle:Number n  WHERE n.film = :film ORDER BY n.beginTc'
        );
        $query->setParameter('film', $film);
        $payload['numbersOf1Film'] = $query->getResult();

        //moyenne des number pour le film
        $query =  $this->em->createQuery(
            'SELECT SUM(f.length) / COUNT(f.title) as average FROM AppBundle:Number f WHERE f.film = :film'
        );
        $query->setParameter('film', $film);
        $payload['numberAverageLength'] = $query->getResult();

        //moyenne des number pour tous les films
        $query =  $this->em->createQuery(
            'SELECT SUM(f.length) / COUNT(f.title) as average FROM AppBundle:Number f'
        );
        $payload['numbersAverageLength'] = $query->getResult();

        //addition de tous les numbers pour le film
        $query =  $this->em->createQuery(
            'SELECT SUM(n.length) as total, (f.length) as length FROM AppBundle:Number n JOIN n.film f WHERE n.film = :film'
        );
        $query->setParameter('film', $film);
        $payload['numberSumLength'] = $query->getResult();

        //persons linked to a movie
        $query =  $this->em->createQuery(
            'SELECT a.personId as personId FROM AppBundle:FilmHasPerson a WHERE a.filmId = :film' //film has person
        ); //SELECT p.name FROM AppBundle:Person p WHERE p.personId IN ()
        $query->setParameter('film', $film);
        $payload['persons1Film'] = $query->getResult();

        //        //persons linked to a movie
        $query = $this->em->createQuery(
            'SELECT a.personId as personId FROM AppBundle:FilmHasPerson a WHERE a.filmId = :film' //film has person
        );
        $query->setParameter('film', $film);
        $payload['persons1Film'] = $query->getResult();

        return $payload;
    }


}