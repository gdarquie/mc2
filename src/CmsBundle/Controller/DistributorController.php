<?php

namespace CmsBundle\Controller;

use AppBundle\Entity\Distributor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Distributor controller.
 *
 * @Route("admin/distributor")
 */
class DistributorController extends Controller
{
    /**
     * Lists all distributor entities.
     *
     * @Route("/", name="admin_distributor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $distributors = $em->getRepository('AppBundle:Distributor')->findAll();

        return $this->render('CmsBundle:Distributor:index.html.twig', array(
            'distributors' => $distributors,
        ));
    }

    /**
     * Creates a new distributor entity.
     *
     * @Route("/new", name="admin_distributor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $distributor = new Distributor();
        $form = $this->createForm('AppBundle\Form\DistributorType', $distributor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $distributor->setDateCreation($now);
            $distributor->setLastUpdate($now);

            $em->persist($distributor);
            $em->flush();

            return $this->redirectToRoute('admin_distributor_show', array('distributorId' => $distributor->getDistributorid()));
        }

        return $this->render('CmsBundle:Distributor:new.html.twig', array(
            'distributor' => $distributor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a distributor entity.
     *
     * @Route("/{distributorId}", name="admin_distributor_show")
     * @Method("GET")
     */
    public function showAction(Distributor $distributor)
    {
        $deleteForm = $this->createDeleteForm($distributor);

        return $this->render('CmsBundle:Distributor:show.html.twig', array(
            'distributor' => $distributor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing distributor entity.
     *
     * @Route("/{distributorId}/edit", name="admin_distributor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Distributor $distributor)
    {
        $deleteForm = $this->createDeleteForm($distributor);
        $editForm = $this->createForm('AppBundle\Form\DistributorType', $distributor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $now = new \DateTime();
            $distributor->setDateCreation($now);
            $distributor->setLastUpdate($now);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_distributor_index', array('distributorId' => $distributor->getDistributorid()));
        }

        return $this->render('CmsBundle:Distributor:edit.html.twig', array(
            'distributor' => $distributor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a distributor entity.
     *
     * @Route("/{distributorId}", name="admin_distributor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Distributor $distributor)
    {
        $form = $this->createDeleteForm($distributor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($distributor);
            $em->flush();
        }

        return $this->redirectToRoute('admin_distributor_index');
    }

    /**
     * Creates a form to delete a distributor entity.
     *
     * @param Distributor $distributor The distributor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Distributor $distributor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_distributor_delete', array('distributorId' => $distributor->getDistributorid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
