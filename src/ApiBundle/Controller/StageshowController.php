<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Stageshow;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api/stageshows")
 */
class StageshowController extends Controller
{
    /**
     * @Route("/")
     */
    public function stageshowsAction(){

        $em = $this->getDoctrine()->getManager();
        $stageshows = $em->getRepository('AppBundle:Stageshow')->findAll();
        $data = array('stageshows' => array());
        foreach ($stageshows as $stageshow) {
            $data['stageshows'][] = $this->serializeStageshow($stageshow);
        }

        $response = new JsonResponse($data, 200);

        return $response;
    }

    private function serializeStageshow(Stageshow $stageshow)
    {
        return array(
            'stageshowId' => $stageshow->getStageshowId(),
            'title' => $stageshow->getTitle()
        );
    }

}