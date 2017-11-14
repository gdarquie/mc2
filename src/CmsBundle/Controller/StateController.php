<?php

namespace CmsBundle\Controller;

use AppBundle\Entity\State;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * State controller.
 *
 * @Route("admin/state")
 */
class StateController extends Controller
{
    /**
     * Lists all state entities.
     *
     * @Route("/", name="admin_state_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $states = $em->getRepository('AppBundle:State')->findAll();

        return $this->render('CmsBundle:State:index.html.twig', array(
            'states' => $states,
        ));
    }

    /**
     * Creates a new state entity.
     *
     * @Route("/new", name="admin_state_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $state = new State();
        $form = $this->createForm('AppBundle\Form\StateType', $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();

            $state->setDateCreation($now);
            $state->setLastUpdate($now);

            $em->persist($state);

            $em->flush();

            return $this->redirectToRoute('admin_state_show', array('stateId' => $state->getStateid()));
        }

        return $this->render('CmsBundle:State:new.html.twig', array(
            'state' => $state,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a state entity.
     *
     * @Route("/{stateId}", name="admin_state_show")
     * @Method("GET")
     */
    public function showAction(State $state)
    {
        $deleteForm = $this->createDeleteForm($state);

        return $this->render('CmsBundle:State:show.html.twig', array(
            'state' => $state,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing state entity.
     *
     * @Route("/{stateId}/edit", name="admin_state_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, State $state)
    {
        $deleteForm = $this->createDeleteForm($state);
        $editForm = $this->createForm('AppBundle\Form\StateType', $state);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $now = new \DateTime();
            $state->setLastUpdate($now);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_state_index');
        }

        return $this->render('CmsBundle:State:edit.html.twig', array(
            'state' => $state,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a state entity.
     *
     * @Route("/{stateId}", name="admin_state_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, State $state)
    {
        $form = $this->createDeleteForm($state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($state);
            $em->flush();
        }

        return $this->redirectToRoute('admin_state_index');
    }

    /**
     * Creates a form to delete a state entity.
     *
     * @param State $state The state entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(State $state)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_state_delete', array('stateId' => $state->getStateid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
