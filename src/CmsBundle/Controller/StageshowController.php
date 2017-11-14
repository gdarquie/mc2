<?php

namespace CmsBundle\Controller;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Stageshow;
use AppBundle\Form\StageshowType;


class StageshowController extends Controller
{
    /**
     * @Route("/editor/stageshow/add/new", name="stageshow_new")
     */
    public function addAction(Request $request){

        $stageshow = new Stageshow();

        $form = $this->createForm(StageshowType::class, $stageshow);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            $stageshow = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $stageshow->setDateCreation($now);
            $stageshow->setLastUpdate($now);

            $user = $this->getUser();
            $stageshow->addEditors($user);

            $em->persist($stageshow);
            $em->flush();

            $this->addFlash('success', 'Stage Show created!');
            return $this->redirectToRoute('admin');
        }

        return $this->render('CmsBundle:Stageshow:new.html.twig', array(
            'stageForm' => $form->createView()
        ));
    }

    /**
     * @Route("/editor/stageshow/id/{stageshowId}/edit" , name = "stageshow_edit")
     */
    public function editAction(Request $request, $stageshowId){

        $em = $this->getDoctrine()->getManager();
        $stageshow = $em->getRepository('AppBundle:Stageshow')->findOneByStageshowId($stageshowId);

        $form = $this->createForm(stageshowType::class, $stageshow);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $stageshow->addEditors($user);
            $em->persist($stageshow);
            $em->flush();

            $this->addFlash('success', 'Stage Show edited!');
            return $this->redirectToRoute('stageshow', array('stageshowId' => $stageshowId));

        }

        return $this->render('CmsBundle:Stageshow:edit.html.twig', array(
            'stageshow' => $stageshow,
            'stageForm' => $form->createView()
        ));
    }

    /**
     * Effacer un item
     *
     * @Route("admin/stageshow/id/{id}/delete", name="stageshow_delete")
     * @Method({"DELETE","GET"})
     */
    public function deleteAction(Stageshow $item)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if (!$item) {
            throw $this->createNotFoundException('No item found');
        }

        $em = $this->getDoctrine()->getManager();

        //select all stagenumbers of the stageshow

        $query = $em->createQuery(
            'SELECT n FROM AppBundle:Stagenumber n JOIN n.stageshow s WHERE s.stageshowId = :id '
        );
        $query->setParameter('id' , $item->getStageshowId());
        $stagenumbers = $query->getResult();
//        dump($stagenumbers);die;

        //delete all stagenumbers
        foreach($stagenumbers as $stagenumber){
            $em->remove($stagenumber);
        }

        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Deleted Successfully!');
        return $this->redirectToRoute('stageshows');
    }

}
