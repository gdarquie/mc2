<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ThesaurusController extends Controller
{

    /**
     * @Route("/thesaurus", name="thesaurus")
     */
    public function thesaurusAction()
    {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT c FROM AppBundle:Code c ORDER BY c.title ASC');
        $codes = $query->getResult();

        return $this->render(
            'AppBundle:thesaurus:accueil.html.twig', array(
                'codes' => $codes
            ));
        
    }

    /**
     * @Route("/thesaurus/type={content}", name="thesaurus_type")
     */
    public function codeAction($content)
    {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT c FROM AppBundle:Code c WHERE c.content = :content');
        $query->setParameter('content', $content);
        $code = $query->getSingleResult();

        $query = $em->createQuery('SELECT c.codeId FROM AppBundle:Code c WHERE c.content = :content');
        $query->setParameter('content', $content);
        $codeId = $query->getSingleResult();
        $codeId = $codeId['codeId'];



        $query = $em->createQuery('SELECT t FROM AppBundle:Thesaurus t INNER JOIN t.code c WHERE c.codeId = :codeId');
        $query->setParameter('codeId', $codeId);
        $thesaurus = $query->getResult();

        return $this->render('AppBundle:thesaurus:code.html.twig', array(
            'code' => $code,
            'thesaurus' => $thesaurus
        ));
    }

    /**
     * @Route("/thesaurus/id={id}", name="thesaurus_element")
     */
    public function elementThesaurusAction($id)
    {

        //les opérations sont construites à partir de 'code'

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT t FROM AppBundle:Thesaurus t WHERE t.id = :id');
        $query->setParameter('id', $id);
        $thesaurus = $query->getSingleResult();

        //Select code de l'id lié
        $query = $em->createQuery('SELECT c.content FROM AppBundle:Thesaurus t JOIN t.code c WHERE t.id = :id');
        $query->setParameter('id', $id);
        $code = $query->getSingleResult();
        $code = $code['content'];

        $numbers = "";
        $films = "";
        $songs = "";
        $stagenumbers = "";


        if($code == "adaptation"){
            //Select toutes les songs avec ce code
            $query = $em->createQuery('SELECT f FROM AppBundle:Film f JOIN f.'.$code.' t WHERE t.id = :id');
            $query->setParameter('id', $id);
            $films = $query->getResult();
        }

        else if($code == "songtype"){
            $query = $em->createQuery('SELECT s FROM AppBundle:Song s JOIN s.'.$code.' t WHERE t.id = :id');
            $query->setParameter('id', $id);
            $songs = $query->getResult();
        }

        else{

            //et les stage numbers
            if($code == "musicals" OR $code == "costumes" OR $code == "dancemble" OR $code == "musensemble" OR $code == "cast" OR $code == "dancing_type" OR $code == "dance_subgenre" OR $code == "dance_content" OR $code == "genre" OR $code == "general_mood"){

                $query = $em->createQuery('SELECT n FROM AppBundle:Stagenumber n JOIN n.'.$code.' t WHERE t.id = :id');
                $query->setParameter('id', $id);
                $stagenumbers = $query->getResult();

            }

            //Select tous les numbers avec ce code (dans tous les cas)
            $query = $em->createQuery('SELECT n FROM AppBundle:Number n JOIN n.'.$code.' t WHERE t.id = :id');
            $query->setParameter('id', $id);
            $numbers = $query->getResult();

        }

        return $this->render('AppBundle:thesaurus:item.html.twig', array(
            'thesaurus' => $thesaurus,
            'numbers' => $numbers,
            'films' => $films,
            'songs' => $songs,
            'stagenumbers' => $stagenumbers
        ));

    }


}
