<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Number;
use AppBundle\Form\NumberType;

class NumberController extends Controller
{

    /**
     * @Route("/number/{id}", name = "number")
     */
    public function showAction($id){
        $em = $this->getDoctrine()->getManager();
        $number = $em->getRepository('AppBundle:Number')->findOneById($id);

        return $this->render('AppBundle:number:number.html.twig',array(
            'number' => $number
        ));
    }
}


