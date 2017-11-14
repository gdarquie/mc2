<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\UserType;

class UserControllerCustom extends Controller
{
    /**
     * @Route("/admin/user/edit/{id}", name="user_edit")
     */
    public function editAction(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($id);


        $form = $this->createForm(userType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dump($user);die;
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $film->addEditors($user);
            $em->persist($film);
            $em->flush();

            $this->addFlash('success', 'Film edited!');

            return $this->redirectToRoute('film', array('filmId' => $filmId));

        }

        return $this->render('CmsBundle:User:', array(
            'form' => $form->createView()
        ));
        
    }
    
    public function deleteAction($name)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        return $this->render('', array('name' => $name));
    }
    
}
