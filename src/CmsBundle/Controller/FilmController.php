<?php
/**
 * Created by PhpStorm.
 * User: gaetan
 * Date: 19/09/2016
 * Time: 11:22
 */

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Film;
use AppBundle\Form\FilmType;

class FilmController extends Controller
{
    /**
     * @Route("/expert/film/add/new", name="editorNewFilm")
     */
    public function addAction(Request $request){

        $film = new Film();

        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $film->addEditors($user);

            $em->persist($film);
            $em->flush();

            $filmId = $film->getFilmId();

            return $this->redirectToRoute('film', array('filmId' => $filmId));
        }

        return $this->render('CmsBundle:Film:new.html.twig', array(
            'filmForm' => $form->createView()
        ));
    }


    /**
     * @Route("/expert/film/id/{filmId}/edit" , name = "film_edit")
     */
    public function filmEditAction(Request $request, $filmId){

        $em = $this->getDoctrine()->getManager();
        $film = $em->getRepository('AppBundle:Film')->findOneByfilmId($filmId);

        $form = $this->createForm(filmType::class, $film);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $film->addEditors($user);
            $em->persist($film);
            $em->flush();

            $this->addFlash('success', 'Film edited!');

            return $this->redirectToRoute('film', array('filmId' => $filmId));


        }

        return $this->render('CmsBundle:Film:edit.html.twig', array(
            'film' => $film,
            'filmForm' => $form->createView()
        ));
    }

    /**
     * Effacer un item
     *
     * @Route("admin/film/id/{id}/delete", name="film_delete")
     * @Method({"DELETE","GET"})
     */
    public function deleteAction(Film $item)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if (!$item) {
            throw $this->createNotFoundException('No item found');
        }

        $em = $this->getDoctrine()->getManager();


        //select tous les numbers du film

        $query = $em->createQuery(
            'SELECT n FROM AppBundle:Number n JOIN n.film f WHERE f.filmId = :id '
        );
        $query->setParameter('id' , $item->getFilmId());
        $numbers = $query->getResult();

        foreach($numbers as $number){
            $em->remove($number);
        }

        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Deleted Successfully!');
        return $this->redirectToRoute('films');
    }


}



