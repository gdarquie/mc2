<?php

namespace CmsBundle\Controller;

use AppBundle\Entity\Code;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Code controller.
 *
 * @Route("admin/code")
 */
class CodeController extends Controller
{
    /**
     * Lists all code entities.
     *
     * @Route("/", name="admin_code_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $codes = $em->getRepository('AppBundle:Code')->findAll();

        return $this->render('CmsBundle:Code:index.html.twig', array(
            'codes' => $codes,
        ));
    }


    /**
     * Finds and displays a code entity.
     *
     * @Route("/{codeId}", name="admin_code_show")
     * @Method("GET")
     */
    public function showAction(Code $code)
    {

        return $this->render('CmsBundle:Code:show.html.twig', array(
            'code' => $code
        ));
    }

    /**
     * Displays a form to edit an existing code entity.
     *
     * @Route("/{codeId}/edit", name="admin_code_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Code $code)
    {
        $editForm = $this->createForm('AppBundle\Form\CodeType', $code);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {


            $user = $this->getUser();
            $code->addEditors($user);

            $now = new \DateTime();
            $code->setLastUpdate($now);


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_code_index');
        }

        return $this->render('CmsBundle:Code:edit.html.twig', array(
            'code' => $code,
            'edit_form' => $editForm->createView()
        ));
    }

}
