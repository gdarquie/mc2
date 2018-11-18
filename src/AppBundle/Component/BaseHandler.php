<?php

namespace AppBundle\Component;

use Doctrine\ORM\EntityManager;

class BaseHandler
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}