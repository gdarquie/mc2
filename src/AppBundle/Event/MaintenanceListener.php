<?php
//
///**
// * Created by PhpStorm.
// * User: gaetan
// * Date: 28/10/2016
//* Time: 11:01
//*/
//
//namespace AppBundle\Event;
//
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpKernel\Event\GetResponseEvent;
//
//class MaintenanceListener
//{
//    private $lockFilePath;
//    private $twig;
//
//    public function __construct($lockFilePath, \Twig_Environment $twig)
//    {
//        $this->lockFilePath = $lockFilePath;
//        $this->twig = $twig;
//    }
//
//    public function onKernelRequest(GetResponseEvent $event)
//    {
//        if ( ! file_exists($this->lockFilePath)) {
//            return;
//        }
//
//        $page = $this->twig->render('::maintenance.html.twig');
//
//        $event->setResponse(
//            new Response(
//                $page,
//                Response::HTTP_SERVICE_UNAVAILABLE
//            )
//        );
//        $event->stopPropagation();
//    }
//}

