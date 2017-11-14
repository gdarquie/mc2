<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class StageshowController extends Controller
{
    /**
     * @Route("/stageshows", name = "stageshows")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $stageshows = $em->getRepository('AppBundle:Stageshow')->findAll();

        return $this->render('AppBundle:stageshow:index.html.twig' , array(
            'stageshows' => $stageshows
        ));
    }

    /**
     * @Route("stageshow/id/{stageshowId}", name="stageshow")
     */
    public function showAction($stageshowId){

        $em = $this->getDoctrine()->getManager();
        $stageshow = $em->getRepository('AppBundle:Stageshow')->findOneByStageshowId($stageshowId);

        return $this->render('AppBundle:stageshow:stageshow.html.twig',array(
            'stageshow' => $stageshow
        ));
    }

}
