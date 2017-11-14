<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ThemeCensorshipController extends Controller
{
    /**
     * @Route("/censorship", name="censorship")
     */
    public function indexAction()
    {
        $em = $this -> getDoctrine()->getManager();

        //Films by Legion
        $query = $em -> createQuery('SELECT f.title as title, f.legion as legion, f.released as released, COUNT(f.filmId) as nb FROM AppBundle:Film f WHERE f.legion IS NOT NULL GROUP BY f.legion');
        $legion = $query->getResult();

        $query = $em -> createQuery('SELECT f.legion as label, COUNT(f.filmId) as value FROM AppBundle:Film f WHERE f.legion IS NOT NULL GROUP BY f.legion');
        $legionJSON = $query->getResult();
        $legionJSON = new JsonResponse($legionJSON);

        //Nb legion par année
        $query = $em -> createQuery('SELECT f.title, f.released, COUNT(f.legion) as nb FROM AppBundle:Film as f WHERE f.released > 0 AND f.legion != :null GROUP BY f.released');
        $query->setParameter('null', '');
        $nbLegion = $query->getResult();

        //nb of all legion
        $query = $em -> createQuery('SELECT COUNT(f.filmId) as nb FROM AppBundle:Film f WHERE f.legion != :null');
        $query->setParameter('null', '');
        $nbFilmsWithLegion = $query->getSingleResult();

        //Films by Harrison
        $query = $em -> createQuery('SELECT f.title as title, f.harrisson as harrison, f.released as released, COUNT(f.filmId) as nb FROM AppBundle:Film f WHERE f.harrisson != :value GROUP BY f.harrisson ');
        $query->setParameter('value', '');
        $harrison = $query->getResult();

        //Films by Protestant
        $query = $em -> createQuery('SELECT f.title as title, f.protestant as protestant, f.released as released, COUNT(f.filmId) as nb FROM AppBundle:Film f WHERE f.protestant != :value  GROUP BY f.protestant');
        $query->setParameter('value', '');
        $protestant = $query->getResult();

        //Films by Board
        $query = $em -> createQuery('SELECT f.title as title, f.bord as board, f.released as released, COUNT(f.filmId) as nb FROM AppBundle:Film f WHERE f.bord != :value  GROUP BY f.bord');
        $query->setParameter('value', '');
        $board = $query->getResult();

        //Films by Verdict
        $query = $em -> createQuery('SELECT f.title as title, f.verdict as verdict, f.released as released, COUNT(f.filmId) as nb FROM AppBundle:Film f WHERE f.verdict != :value GROUP BY f.verdict ORDER BY verdict');
        $query->setParameter('value', '');
        $verdict = $query->getResult();

        //Nb verdict par année // à reprendre pour récupérer toutes les années
        $query = $em -> createQuery('SELECT f.title, f.released, COUNT(f.verdict) as nb FROM AppBundle:Film as f WHERE f.released > 0 AND f.verdict != :null GROUP BY f.released');
        $query->setParameter('null', '');
        $nbVerdict = $query->getResult();

        //Films by studio
        $query = $em -> createQuery('SELECT f.title as title, s.title as studio, f.released as released, COUNT(f.filmId) as nb FROM AppBundle:Film f JOIN f.studios s GROUP BY s.studioId ORDER BY nb DESC');
        $studios = $query->getResult();

        //select all verdict
        $query = $em -> createQuery('SELECT COUNT(f.filmId) as nb FROM AppBundle:Film f WHERE f.verdict != :null');
        $query->setParameter('null', '');
        $nbFilmsWithVerdict = $query->getSingleResult();

        //number of films by studio with verdict
        $query = $em -> createQuery('SELECT s.title as title, COUNT(f.filmId) as nb FROM AppBundle:Film f JOIN f.studios s WHERE f.verdict != :null GROUP BY s.studioId ORDER BY nb DESC');
        $query->setParameter('null', '');
        $nbFilmsWithVerdictByStudio = $query->getResult();

        //number of censored contents (censorships)
        $query = $em -> createQuery('SELECT c.title as title, f.released as released, COUNT(f.filmId) as nb FROM AppBundle:Film f JOIN f.censorship c GROUP BY c.censorshipId ORDER BY title');
        $censorship = $query->getResult();

        $query = $em -> createQuery('SELECT c.title as title, COUNT(f.filmId) as nb FROM AppBundle:Film f JOIN f.censorship c GROUP BY c.censorshipId ORDER BY nb DESC');
        $defCensorship = $query->getResult();

        //Nb verdict par année // à reprendre pour récupérer toutes les années
        $query = $em -> createQuery('SELECT f.title, f.released, COUNT(c.title) as nb FROM AppBundle:Film f JOIN f.censorship c WHERE f.released > 0 GROUP BY f.released');
        $nbCensorship = $query->getResult();

        //nb of all censorships
        $query = $em -> createQuery('SELECT COUNT(f.filmId) as nb FROM AppBundle:Film f JOIN f.censorship c');
        $nbFilmsWithCensorship = $query->getSingleResult();


        return $this->render('AppBundle:censorship:index.html.twig', array(
            'legion' => $legion,
            'legionJSON' => $legionJSON,
            'nbLegion' => $nbLegion,
            'nbFilmsWithLegion' => $nbFilmsWithLegion,
            'harrison' => $harrison,
            'protestant' => $protestant,
            'board' => $board,
            'verdict' =>$verdict,
            'nbVerdict' => $nbVerdict,
            'studios' =>$studios,
            'nbFilmsWithVerdict' => $nbFilmsWithVerdict,
            'nbFilmsWithVerdictByStudio' => $nbFilmsWithVerdictByStudio,
            'censorship' => $censorship,
            'defCensorship' => $defCensorship,
            'nbCensorship' => $nbCensorship,
            'nbFilmsWithCensorship' =>$nbFilmsWithCensorship
        ));
    }

    /**
     * @Route("/censorship/verdict/{verdict}", name="censorship_verdict")
     */
    public function verdictAction($verdict){

        $em = $this->getDoctrine()->getManager();

        $query = $em -> createQuery('SELECT DISTINCT(f.verdict) as title FROM AppBundle:Film f WHERE f.verdict = :verdict');
        $query->setParameter('verdict', $verdict);
        $verdict = $query->getResult();

        //select one verdict
        $query = $em -> createQuery('SELECT f FROM AppBundle:Film f WHERE f.verdict = :verdict');
        $query->setParameter('verdict', $verdict);
        $filmsByVerdict = $query->getResult();

        //select one verdict
        $query = $em -> createQuery('SELECT s.title as title, COUNT(f.filmId) as nb FROM AppBundle:Film f JOIN f.studios s WHERE f.verdict = :verdict GROUP BY s.studioId ORDER BY nb DESC');
        $query->setParameter('verdict', $verdict);
        $studiosByVerdict = $query->getResult();

        //select all verdict
        $query = $em -> createQuery('SELECT COUNT(f.filmId) as nb FROM AppBundle:Film f WHERE f.verdict != :null');
        $query->setParameter('null', '');
        $nbFilmsWithVerdict = $query->getSingleResult();

        //number of films by studio with verdict
        $query = $em -> createQuery('SELECT s.title as title, COUNT(f.filmId) as nb FROM AppBundle:Film f JOIN f.studios s WHERE f.verdict != :null GROUP BY s.studioId ORDER BY nb DESC');
        $query->setParameter('null', '');
        $nbFilmsWithVerdictByStudio = $query->getResult();

        return $this->render('AppBundle:censorship:verdict.html.twig', array(
            'filmsByVerdict' => $filmsByVerdict,
            'studiosByVerdict' => $studiosByVerdict,
            'verdict' => $verdict,
            'nbFilmsWithVerdict' => $nbFilmsWithVerdict,
            'nbFilmsWithVerdictByStudio' => $nbFilmsWithVerdictByStudio
        ));

    }

    /**
     * @Route("/censorship/content/{content}", name="censorship_content")
     */
    public function contentAction($content){

        $em = $this->getDoctrine()->getManager();

        $query = $em -> createQuery('SELECT DISTINCT(f.title) as title FROM AppBundle:Film f JOIN f.censorship c WHERE c.title = :content');
        $query->setParameter('content', $content);
        $filmsByContent = $query->getResult();

        $query = $em -> createQuery('SELECT f FROM AppBundle:Film f JOIN f.censorship c WHERE c.title = :content');
        $query->setParameter('content', $content);
        $films = $query->getResult();

        $query = $em -> createQuery('SELECT s.title as title, COUNT(f.filmId) as nb FROM AppBundle:Film f JOIN f.censorship c JOIN f.studios s WHERE c.title = :content GROUP BY s.studioId ORDER BY nb DESC');
        $query->setParameter('content', $content);
        $studiosByContent = $query->getResult();

        $query = $em->createQuery('SELECT DISTINCT(c.title) as title FROM AppBundle:Film f JOIN f.censorship c WHERE c.title = :content');
        $query->setParameter('content', $content);
        $myContent = $query->getSingleResult();

        $query = $em->createQuery('SELECT g.title as title, COUNT(f.filmId) as nb FROM AppBundle:Number n JOIN n.film f JOIN n.genre g JOIN f.censorship c  WHERE c.title = :content GROUP BY g.id ORDER BY nb DESC');
        $query->setParameter('content', $content);
        $genres = $query->getResult();

        $query = $em->createQuery('SELECT d.title as title, COUNT(f.filmId) as nb FROM AppBundle:Number n JOIN n.film f JOIN n.dance_content d JOIN f.censorship c  WHERE c.title = :content GROUP BY d.id ORDER BY nb DESC');
        $query->setParameter('content', $content);
        $danceContents = $query->getResult();



        return $this->render('AppBundle:censorship:content.html.twig', array(
            'filmsByContent' => $filmsByContent,
            'films' => $films,
            'studiosByContent' => $studiosByContent,
            'myContent' => $myContent,
            'genres' => $genres,
            'danceContents' => $danceContents
//            'studiosByContent' => $studiosByVerdict,

        ));

    }

    /**
     * @Route("/censorship/legion/{legion}", name="censorship_legion")
     */
    public function legionAction($legion){

        $em = $this->getDoctrine()->getManager();

        $query = $em -> createQuery('SELECT DISTINCT(f.title) as title, f.idImdb as idImdb FROM AppBundle:Film f WHERE f.legion = :legion');
        $query->setParameter('legion', $legion);
        $filmsByLegion = $query->getResult();

        $query = $em -> createQuery('SELECT f FROM AppBundle:Film f WHERE f.legion = :legion');
        $query->setParameter('legion', $legion);
        $films = $query->getResult();

        $query = $em -> createQuery('SELECT DISTINCT(f.title) as title, f.released as released, COUNT(DISTINCT(f.filmId)) as nb, f.idImdb as idImdb, f.legion as legion FROM AppBundle:Film f WHERE f.legion = :legion GROUP BY f.released');
        $query->setParameter('legion', $legion);
        $filmsByYear = $query->getResult();

        $query = $em->createQuery('SELECT DISTINCT(f.legion) as title, COUNT(DISTINCT(f.filmId)) as nb FROM AppBundle:Film f WHERE f.legion = :legion');
        $query->setParameter('legion', $legion);
        $myLegion = $query->getSingleResult();

        $query = $em->createQuery('SELECT COUNT(DISTINCT(n.id)) as nb FROM AppBundle:Film f JOIN f.numbers n WHERE f.legion = :legion');
        $query->setParameter('legion', $legion);
        $numberForLegion = $query->getSingleResult();

        //genres
        $query = $em->createQuery('SELECT g.title as title, COUNT(f.filmId) as nb FROM AppBundle:Number n JOIN n.film f JOIN n.genre g WHERE f.legion = :legion GROUP BY g.id ORDER BY nb DESC');
        $query->setParameter('legion', $legion);
        $genres = $query->getResult();

        //dance contents
        $query = $em->createQuery('SELECT d.title as title, f.legion as legion, d.id as id, COUNT(f.filmId) as nb FROM AppBundle:Number n JOIN n.film f JOIN n.dance_content d  WHERE f.legion = :legion GROUP BY d.id ORDER BY nb DESC');
        $query->setParameter('legion', $legion);
        $danceContents = $query->getResult();

        //costumes
        $query = $em->createQuery('SELECT g.title as title, COUNT(f.filmId) as nb FROM AppBundle:Number n JOIN n.film f JOIN n.costumes g WHERE f.legion = :legion GROUP BY g.id ORDER BY nb DESC');
        $query->setParameter('legion', $legion);
        $costumes = $query->getResult();

        //costumes
        $query = $em->createQuery('SELECT g.title as title, COUNT(f.filmId) as nb FROM AppBundle:Number n JOIN n.film f JOIN n.stereotype g WHERE f.legion = :legion GROUP BY g.id ORDER BY nb DESC');
        $query->setParameter('legion', $legion);
        $stereotypes = $query->getResult();

        //group legion by studio
        $query = $em -> createQuery('SELECT s.title as title, COUNT(f.filmId) as nb FROM AppBundle:Film f JOIN f.studios s WHERE f.legion = :legion GROUP BY s.studioId ORDER BY nb DESC');
        $query->setParameter('legion', $legion);
        $studiosByLegion = $query->getResult();

        return $this->render('AppBundle:censorship:legion.html.twig', array(
            'filmsByLegion' => $filmsByLegion,
            'films' => $films,
            'myLegion' => $myLegion,
            'genres' => $genres,
            'costumes' =>$costumes,
            'stereotypes' => $stereotypes,
            'danceContents' => $danceContents,
            'studiosByLegion' => $studiosByLegion,
            'numberForLegion' => $numberForLegion,
            'filmsByYear' => $filmsByYear
        ));
    }


    /**
     * Voir un item
     *
     * @Route("editor/censorship/id/{id}", name="censorship_show")
     * @Method({"GET"})
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $censorship = $em->getRepository('AppBundle:Censorship')->find($id);

        return $this->render('AppBundle:censorship:item.html.twig', array(
            'censorship' => $censorship
        ));
        
    }

    /**
     * Effacer un item
     *
     * @Route("editor/censorship/id/{id}/delete", name="censorship_delete")
     * @Method({"DELETE","GET"})
     */
    public function deleteAction(Censorhsip $item)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if (!$item) {
            throw $this->createNotFoundException('No item found');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Deleted Successfully!');
        return $this->redirectToRoute('admin');
    }


}
