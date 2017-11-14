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

use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;


class PersonController extends Controller
{
    /**
     * @Route("/expert/person/add/new", name="editorNewPerson")
     */
    public function addAction(Request $request)
    {

        $person = new person();

        $form = $this->createForm(personType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $collection = new \Doctrine\Common\Collections\ArrayCollection();
            $user = $this->getUser();
            $collection->add($user);

            $person->setEditors($collection);

            $now = new \DateTime();
            $person->setDateCreation($now);
            $person->setLastUpdate($now);

            $em->persist($person);
            $em->flush();

            return $this->redirectToRoute('editor');
        }

        return $this->render('CmsBundle:Person:new.html.twig', array(
            'personForm' => $form->createView()
        ));
    }


    /**
     * @Route("/expert/person/id/{personId}/edit" , name = "person_edit")
     */
    public function personEditAction(Request $request, $personId)
    {

        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('AppBundle:Person')->findOneBypersonId($personId);

        $form = $this->createForm(personType::class, $person);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $collection = new \Doctrine\Common\Collections\ArrayCollection();
            $user = $this->getUser();
            $collection->add($user);
            $person->setEditors($collection);

            $now = new \DateTime();
            $person->setLastUpdate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            return $this->redirectToRoute('person', array('personId' => $person->getPersonId()));
        }

        return $this->render('CmsBundle:Person:edit.html.twig', array(
            'person' => $person,
            'personForm' => $form->createView()
        ));
    }

    /**
     * Effacer un item
     *
     * @Route("admin/person/id/{id}/delete", name="person_delete")
     * @Method({"DELETE","GET"})
     */
    public function deleteAction(Person $item)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if (!$item) {
            throw $this->createNotFoundException('No item found');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Deleted Successfully!');
        return $this->redirectToRoute('persons');
    }
}

