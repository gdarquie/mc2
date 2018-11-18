<?php

namespace AppBundle\Component;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

class BaseHandler
{
    protected $em;
    protected $router;

    /**
     * BaseHandler constructor.
     * @param EntityManagerInterface $em
     * @param RouterInterface $router
     */
    public function __construct(EntityManagerInterface $em, RouterInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }
}