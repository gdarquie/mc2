<?php

namespace AppBundle\Component;

use Doctrine\ORM\EntityManager;

class DefaultHander
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}