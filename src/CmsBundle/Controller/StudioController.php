<?php

namespace CmsBundle\Controller;

use AppBundle\Entity\Studio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Studio controller.
 *
 * @Route("admin/studio")
 */
class StudioController extends Controller
{
    /**
     * Lists all studio entities.
     *
     * @Route("/", name="admin_studio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $studios = $em->getRepository('AppBundle:Studio')->findAll();

        return $this->render('CmsBundle:Studio:index.html.twig', array(
            'studios' => $studios,
        ));
    }

    /**
     * Creates a new studio entity.
     *
     * @Route("/new", name="admin_studio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $studio = new Studio();
        $form = $this->createForm('AppBundle\Form\StudioType', $studio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $studio->setDateCreation($now);
            $studio->setLastUpdate($now);


            $em->persist($studio);
            $em->flush();

            return $this->redirectToRoute('admin_studio_show', array('studioId' => $studio->getStudioid()));
        }

        return $this->render('CmsBundle:Studio:new.html.twig', array(
            'studio' => $studio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a studio entity.
     *
     * @Route("/{studioId}", name="admin_studio_show")
     * @Method("GET")
     */
    public function showAction(Studio $studio)
    {
        $deleteForm = $this->createDeleteForm($studio);

        return $this->render('CmsBundle:Studio:show.html.twig', array(
            'studio' => $studio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing studio entity.
     *
     * @Route("/{studioId}/edit", name="admin_studio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Studio $studio)
    {
        $deleteForm = $this->createDeleteForm($studio);
        $editForm = $this->createForm('AppBundle\Form\StudioType', $studio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $now = new \DateTime();
            $studio->setLastUpdate($now);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_studio_index');
        }

        return $this->render('CmsBundle:Studio:edit.html.twig', array(
            'studio' => $studio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a studio entity.
     *
     * @Route("/{studioId}", name="admin_studio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Studio $studio)
    {
        $form = $this->createDeleteForm($studio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($studio);
            $em->flush();
        }

        return $this->redirectToRoute('admin_studio_index');
    }

    /**
     * Creates a form to delete a studio entity.
     *
     * @param Studio $studio The studio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Studio $studio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_studio_delete', array('studioId' => $studio->getStudioid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
