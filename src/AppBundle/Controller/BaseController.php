<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected function getHandler($modelType) {

        return $this->get($modelType.'_handler');
    }
}
