<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;



class StagenumberController extends Controller
{
    /**
     * @Route("stagenumber/id/{stagenumberId}", name="stagenumber")
     */
    public function showAction($stagenumberId){

        $em = $this->getDoctrine()->getManager();
        $stagenumber = $em->getRepository('AppBundle:Stagenumber')->findOneByStagenumberId($stagenumberId);

        return $this->render('AppBundle:stagenumber:stagenumber.html.twig',array(
            'stagenumber' => $stagenumber
        ));
    }


}