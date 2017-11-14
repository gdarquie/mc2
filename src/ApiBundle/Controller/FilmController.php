<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Film;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
* @Route("/api/films")
*/
class FilmController extends Controller{

	/**
	* @Route("/test")
	*/
	public function testAction(){

		return new Response("Test de l'API de MC2");
	}

	/**
	* @Route("/")
	*/
	public function filmsAction(){

		$em = $this->getDoctrine()->getManager();
		$films = $em->getRepository('AppBundle:Film')->findAll(); 
        $data = array('films' => array());
        foreach ($films as $film) {
            $data['films'][] = $this->serializeFilm($film);
        }

		 $response = new JsonResponse($data, 200);

		 return $response;
	}


	/**
	* @Route("/title")
	*/
	public function filmsByTitleAction(){

		//retourner les titres de tous les films par ordre alphabétique

		$em = $this->getDoctrine()->getManager();
		$films = $em->getRepository('AppBundle:Film')->findAll(); 
        $data = array('films' => array());
        foreach ($films as $film) {
            $data['films'][] = $this->serializeFilmTitle($film);
        }

		 $response = new JsonResponse($data, 200);

		 return $response;
	}

	//si l'user est connecté : tous ses films?


	private function serializeFilmTitle(Film $film)
    {
        return array(
            'title' => $film->getTitle(),
        );
    }

	private function serializeFilm(Film $film)
    {
        return array(
            'title' => $film->getTitle(),
            'released' => $film->getReleased(),
            'filmId' => $film->getFilmId(),
        );
    }


}