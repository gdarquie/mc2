<?php

namespace CmsBundle\Controller;

use AppBundle\Entity\Censorship;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Censorship controller.
 *
 * @Route("admin/censorship")
 */
class CensorshipController extends Controller
{
    /**
     * Lists all censorship entities.
     *
     * @Route("/", name="admin_censorship_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $censorships = $em->getRepository('AppBundle:Censorship')->findAll();

        return $this->render('CmsBundle:Censorship:index.html.twig', array(
            'censorships' => $censorships,
        ));
    }

    /**
     * Creates a new censorship entity.
     *
     * @Route("/new", name="admin_censorship_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $censorship = new Censorship();
        $form = $this->createForm('AppBundle\Form\CensorshipType', $censorship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $censorship->addEditors($user);
            $now = new \DateTime();
            $censorship->setDateCreation($now);
            $censorship->setLastUpdate($now);
            $em->persist($censorship);
            $em->flush();

            return $this->redirectToRoute('admin_censorship_show', array('censorshipId' => $censorship->getCensorshipid()));
        }

        return $this->render('CmsBundle:Censorship:new.html.twig', array(
            'censorship' => $censorship,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a censorship entity.
     *
     * @Route("/{censorshipId}", name="admin_censorship_show")
     * @Method("GET")
     */
    public function showAction(Censorship $censorship)
    {
        $deleteForm = $this->createDeleteForm($censorship);

        return $this->render('CmsBundle:Censorship:show.html.twig', array(
            'censorship' => $censorship,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing censorship entity.
     *
     * @Route("/{censorshipId}/edit", name="admin_censorship_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Censorship $censorship)
    {
        $deleteForm = $this->createDeleteForm($censorship);
        $editForm = $this->createForm('AppBundle\Form\CensorshipType', $censorship);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $now = new \DateTime();
            $censorship->setLastUpdate($now);
            $user = $this->getUser();
            $censorship->addEditors($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_censorship_index');
        }

        return $this->render('CmsBundle:Censorship:edit.html.twig', array(
            'censorship' => $censorship,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a censorship entity.
     *
     * @Route("/{censorshipId}", name="admin_censorship_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Censorship $censorship)
    {
        $form = $this->createDeleteForm($censorship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($censorship);
            $em->flush();
        }

        return $this->redirectToRoute('admin_censorship_index');
    }

    /**
     * Creates a form to delete a censorship entity.
     *
     * @param Censorship $censorship The censorship entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Censorship $censorship)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_censorship_delete', array('censorshipId' => $censorship->getCensorshipid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Effacer un item
     *
     * @Route("censorship/{id}/delete", name="censorship_delete")
     * @Method({"DELETE","GET"})
     */
    public function deleteCustomAction(Censorship $censorship)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if (!$censorship) {
            throw $this->createNotFoundException('No thesaurus found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($censorship);
        $em->flush();

        $this->addFlash('success', 'Deleted Successfully!');
        return $this->redirectToRoute('admin');
    }
}
