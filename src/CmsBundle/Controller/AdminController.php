<?php

namespace CmsBundle\Controller;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;

/**
 * @Route("admin")
 */
class AdminController extends Controller
{

    /**
     * @Route("/", name="admin")
     */
    public function adminAction()
    {

        $max = 15;
        $em = $this->getDoctrine()->getManager();

        //all les users
        $query = $em->createQuery(
            'SELECT u FROM AppBundle:User u ORDER BY u.lastLogin DESC'
        );
        $users = $query->getResult();

        //all films
        $films = $em->getRepository('AppBundle:Film')->findAll();

        //number of numbers by users
        $query = $em->createQuery(
            'SELECT COUNT(n) as nb, u.username as name FROM AppBundle:Number n JOIN n.editors u GROUP by u ORDER BY nb DESC'
        );
        $numbersByEditor = $query->getResult();

        //Numbers
        $query = $em->createQuery(
            'SELECT n FROM AppBundle:Number n WHERE n.date_creation is NOT null ORDER by n.last_update DESC '
        );
        $query->setMaxResults($max);
        $lastNumbers = $query->getResult();

        //Films
        $query = $em->createQuery(
            'SELECT f FROM AppBundle:Film f ORDER by f.last_update DESC '
        );
        $query->setMaxResults($max);
        $lastFilms = $query->getResult();

        //Songs
        $query = $em->createQuery(
            'SELECT s FROM AppBundle:Song s ORDER by s.last_update DESC '
        );
        $query->setMaxResults($max);
        $lastSongs = $query->getResult();

        //Stage Shows
        $query = $em->createQuery(
            'SELECT s FROM AppBundle:Stageshow s ORDER by s.last_update DESC '
        );
        $query->setMaxResults($max);
        $lastStageshows = $query->getResult();

        //Stage numbers
        $query = $em->createQuery(
            'SELECT s FROM AppBundle:Stagenumber s ORDER by s.last_update DESC '
        );
        $query->setMaxResults($max);
        $lastStagenumbers = $query->getResult();

        //Censorship
        $query = $em->createQuery(
            'SELECT c FROM AppBundle:Censorship c ORDER by c.last_update DESC '
        );
        $query->setMaxResults($max);
        $lastCensorhsip = $query->getResult();

        //Thésaurus
        $query = $em->createQuery(
            'SELECT t FROM AppBundle:Thesaurus t ORDER by t.title ASC '
        );
        $query->setMaxResults($max);
        $lastThesaurus = $query->getResult();

        $query = $em->createQuery(
            'SELECT t FROM AppBundle:Person t ORDER by t.name ASC '
        );
        $query->setMaxResults($max);
        $lastpersons = $query->getResult();


        //number by month
        $query = $em->createQuery(
            'SELECT n.title as title, COUNT(n.title) as nb, SUBSTRING(n.last_update, 9, 2) as day, SUBSTRING(n.last_update, 6,2) as month, SUBSTRING(n.last_update, 1,4) as year FROM AppBundle:Number n WHERE n.last_update > 0 GROUP BY month , day'

        );
        $numberByMonth = $query->getResult();

        //all numbers with a part needs help to be completed (une fonction éditeur)
        $lastcheked = "";

        return $this->render('CmsBundle:Admin:index.html.twig', array(
            'users' => $users,
            'numbersByEditor' => $numbersByEditor,
            'lastnumbers' => $lastNumbers,
            'numberByMonth' => $numberByMonth,
            'films' => $films,
            'lastfilms' => $lastFilms,
            'lastsongs' => $lastSongs,
            'laststageshows' => $lastStageshows,
            'laststagenumbers' => $lastStagenumbers,
            'lastcensorhsip' => $lastCensorhsip,
            'lastthesaurus' => $lastThesaurus,
            'lastpersons' => $lastpersons
        ));
    }

    /**
     * @Route("/users", name="admin_users")
     */
    public function RoleAdmin(){

        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('CmsBundle:Admin:roles.html.twig', array(
            'users' => $users,
        ));

    }



}

