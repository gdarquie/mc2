<?php

namespace CmsBundle\Controller;

use AppBundle\Entity\Number;
use AppBundle\Form\NumberType;
use AppBundle\Form\EditorNumberType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class NumberController extends Controller
{
//Number (add a number for a pre-existing film)

    /**
     * @Route("/member/film/id/{filmId}/number/new" , name = "number_new")
     */
    public function numberNewAction(Request $request, $filmId)
    {

        $form = $this->createForm(NumberType::class); //add $number

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $number = $form->getData();

            //récupération d'un film
            $em = $this->getDoctrine()->getManager();

            //all films
            $film = $em->getRepository('AppBundle:Film')->findOneByFilmId($filmId);

            //calcule length
            $begin = $number->getBeginTc();
            $end = $number->getEndTc();
            $length = $end-$begin;
            $number->setLength($length);

            $user = $this->getUser();

            $number->setFilm($film);
            $number->addEditors($user);

            $now = new \DateTime();
            $number->setDateCreation($now);
            $number->setLastUpdate($now);

            $this->validate($number, $user);

            $em->persist($number);
            $em->flush();

            $this->addFlash('success', 'Number created!');

            return $this->redirectToRoute('film', array('filmId' => $filmId));
        }

        return $this->render('CmsBundle:Number:save.html.twig',array(
            'numberForm' => $form->createView(),
            'filmId' => $filmId,
        ));
    }

    /**
     * @Route("/member/number/id/{id}/edit" , name = "number_edit")
     */
    public function numberEditAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $number = $em->getRepository('AppBundle:Number')->findOneById($id);
        $film = $number->getFilm();
        $filmId = $film->getFilmId();

        $validationTitle = $number->getValidationTitle();
        $validationDirector = $number->getValidationDirector();
        $validationTc = $number->getValidationTc();
        $validationStructure = $number->getValidationStructure();
        $validationShots = $number->getValidationShots();
        $validationPerformance = $number->getValidationPerformance();
        $validationBackstage = $number->getValidationBackstage();
        $validationTheme = $number->getValidationTheme();
        $validationMood = $number->getValidationMood();
        $validationDance = $number->getValidationDance();
        $validationMusic = $number->getValidationMusic();
        $validationReference = $number->getValidationReference();
        $validationCost = $number->getValidationCost();

        if($this->isGranted('ROLE_EDITOR')){
            $form = $this->createForm(EditorNumberType::class, $number);
        }
        else{
            $form = $this->createForm(NumberType::class, $number);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            // dump($form->getData());die;

            //calcule length
            $begin = $number->getBeginTc();
            $end = $number->getEndTc();
            $length = $end-$begin;
            $number->setLength($length);

            $user = $this->getUser();
            $number->addEditors($user);

            $now = new \DateTime();
            $number->setLastUpdate($now);

            if($this->isGranted('ROLE_EDITOR')){
                $this->validate($number, $user);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($number);
            $em->flush();

            return $this->redirectToRoute('film', array('filmId' => $filmId));
        }

        return $this->render('CmsBundle:Number:save.html.twig', array(
            'number' => $number,
            'numberForm' => $form->createView(),
            'validationTitle' => $validationTitle,
            'validationDirector' => $validationDirector,
            'validationTc' => $validationTc,
            'validationStructure' => $validationStructure,
            'validationShots' => $validationShots,
            'validationPerformance' => $validationPerformance,
            'validationBackstage' => $validationBackstage,
            'validationTheme' => $validationTheme,
            'validationMood' => $validationMood,
            'validationDance' => $validationDance,
            'validationMusic' => $validationMusic,
            'validationReference' => $validationReference,
            'validationCost'=> $validationCost,

        ));
    }

    /**
     * Fonction pour effacer via ajax un number
     *
     * @Route("member/delete/{numberId}", name="number_ajax_delete")
     * @Method("DELETE")
     */
    public function deleteAjaxAction($numberId)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if ($user->hasRole('ROLE_ADMIN')){

            /** @var Number $number */
            $number = $em->getRepository('AppBundle:Number')
                ->find($numberId);
            $em->remove($number);
            $em->flush();
        }

        return new Response(null, 204);

    }


    /**
     * Effacer un item
     *
     * @Route("admin/{id}/delete", name="number_delete")
     * @Method({"DELETE","GET"})
     */
    public function deleteAction(Number $number)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if (!$number) {
            throw $this->createNotFoundException('No number found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($number);
        $em->flush();

        $this->addFlash('success', 'Deleted Successfully!');
        return $this->redirectToRoute('numbers');
    }

    /**
     * Créer un form pour effacer un item
     *
     * @param Number $number
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Number $number)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('number_delete', array('id' => $number->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


    private function validate(Number $number, $user){

        $types = array();
        $types[0] = "validationTitle";
        $types[1] = "validationDirector";
        $types[2] = "validationTc";
        $types[3] = "validationStructure";
        $types[4] = "validationShots";
        $types[5] = "validationPerformance";
        $types[6] = "validationBackstage";
        $types[7] = "validationTheme";
        $types[8] = "validationMood";
        $types[9] = "validationDance";
        $types[10] = "validationMusic";
        $types[11] = "validationReference";
        $types[12] = "validationCost";


        for ($counter=0 ; $counter<count($types) ; $counter++){

            $part = $types[$counter];
            $partMaj = ucfirst($part);
            $getter = "get".$partMaj;
            $part  = $number->$getter();


            foreach($part as $validation){
                $validation_title = $validation->getTitle();

                if($validation->getTitle() != null){

                    $validation->setTitle($validation_title);
                    $validation->setUser($user);
                }

                else{
                    $validation->setTitle('No title');
                    $validation->setUser($user);
                }
            }


        }


    }

}
