<?php

namespace CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Stagenumber;
use AppBundle\Form\StagenumberType;

class StagenumberController extends Controller
{
    /**
     * @Route("/editor/stageshow/id/{stageshowId}/stagenumber/new", name="stagenumber_new")
     */
    public function addAction(Request $request, $stageshowId){

        $stagenumber = new Stagenumber();

        $form = $this->createForm(StagenumberType::class, $stagenumber);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            $stagenumber = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $stageshow = $em->getRepository('AppBundle:Stageshow')->findOneByStageshowId($stageshowId);

            //addstageshow & last user
            $stagenumber->setStageshow($stageshow);

            $now = new \DateTime();
            $stagenumber->setDateCreation($now);
            $stagenumber->setLastUpdate($now);

            $em->persist($stagenumber);
            $em->flush();

            $this->addFlash('success', 'Stage Number created!');

            return $this->redirectToRoute('stageshow', array('stageshowId' => $stageshowId));
        }

        return $this->render('CmsBundle:Stagenumber:new.html.twig', array(
            'stagenumberForm' => $form->createView()
        ));
    }


    /**
     * @Route("/editor/stagenumber/id/{stagenumberId}/edit" , name = "stagenumber_edit")
     */
    public function editAction(Request $request, $stagenumberId){

        $em = $this->getDoctrine()->getManager();

        $stagenumber = $em->getRepository('AppBundle:Stagenumber')->findOneByStagenumberId($stagenumberId);

//        dump($stagenumber);die();
        $form = $this->createForm(StagenumberType::class, $stagenumber);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $stagenumber = $form->getData();

            $now = new \DateTime();

            $stageshow = $stagenumber->getStageshow();
            $stageshowId = $stageshow->getStageshowId();
            $stagenumber->setLastUpdate($now);

            $em->persist($stagenumber);
            $em->flush();

            $this->addFlash('success', 'Stage Number edited!');
            return $this->redirectToRoute('stageshow', array('stageshowId' => $stageshowId));

        }

        return $this->render('CmsBundle:Stagenumber:edit.html.twig', array(
            'stagenumber' => $stagenumber,
            'stagenumberForm' => $form->createView()
        ));
    }


    /**
     * Effacer un item
     *
     * @Route("admin/stagenumber/id/{id}/delete", name="stagenumber_delete")
     * @Method({"DELETE","GET"})
     */
    public function deleteAction(Stagenumber $item)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if (!$item) {
            throw $this->createNotFoundException('No item found');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Deleted Successfully!');
        return $this->redirectToRoute('stagenumbers');
    }

}
