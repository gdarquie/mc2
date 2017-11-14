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

use AppBundle\Entity\Song;
use AppBundle\Form\SongType;

class SongController extends Controller
{
    /**
     * @Route("/editor/song/add/new", name="editorNewSong")
     */
    public function addAction(Request $request){

        $song = new Song();

        $form = $this->createForm(SongType::class, $song);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();

            $collection = new \Doctrine\Common\Collections\ArrayCollection();
            $user = $this->getUser();
            $collection->add($user);

            $song->setEditors($collection);

            $now = new \DateTime();
            $song->setDateCreation($now);
            $song->setLastUpdate($now);

            $em->persist($song);
            $em->flush();

            return $this->redirectToRoute('editor');
        }

        return $this->render('CmsBundle:Song:new.html.twig', array(
            'songForm' => $form->createView()
        ));
    }


    /**
     * @Route("/editor/song/id/{songId}/edit" , name = "song_edit")
     */
    public function songEditAction(Request $request, $songId){

        $em = $this->getDoctrine()->getManager();
        $song = $em->getRepository('AppBundle:Song')->findOneBysongId($songId);

        $form = $this->createForm(songType::class, $song);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $collection = new \Doctrine\Common\Collections\ArrayCollection();
            $user = $this->getUser();
            $collection->add($user);
            $song->setEditors($collection);

            $now = new \DateTime();
            $song->setLastUpdate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($song);
            $em->flush();

            $this->addFlash('success', 'Edited');

            return $this->redirectToRoute('song', array('songId' => $songId)); //ramène à la fiche song de départ
        }

        return $this->render('CmsBundle:Song:edit.html.twig', array(
            'song' => $song,
            'songForm' => $form->createView()
        ));
    }

    /**
     * Effacer un item
     *
     * @Route("admin/song/id/{id}/delete", name="song_delete")
     * @Method({"DELETE","GET"})
     */
    public function deleteAction(Song $item)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if (!$item) {
            throw $this->createNotFoundException('No item found');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Deleted Successfully!');
        return $this->redirectToRoute('songs');
    }

}



