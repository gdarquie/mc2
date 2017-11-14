<?php

namespace CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Validation controller.
 *
 * @Route("validation")
 */
class ValidationController extends Controller
{

    /**
     *
     * @Route("/", name="validation")
     * @Method("GET")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        //sélectionner tous les films qui ne sont pas encore validés deux fois

        $query = $em->createQuery('SELECT n FROM AppBundle:Number n');
        $numbers = $query->getResult();

        return $this->render('CmsBundle:Validation:index.html.twig', array(

        ));
    }
}
