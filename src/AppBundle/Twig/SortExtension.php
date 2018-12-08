<?php

namespace AppBundle\Twig;

use Twig_Extension;

class SortExtension extends Twig_Extension
{
    public function getFilters()
    {
        return array(
            'myfilter' => new \Twig_SimpleFilter('usortFilmByReleased', array($this, 'usortFilterFilmByReleased')
        ));
    }

    public function usortFilterFilmByReleased($item){
        usort($item, function ($item1, $item2) {
            if ($item1->getReleased() == $item2->getReleased()) return 0;
            return $item1->getReleased() < $item2->getReleased() ? -1 : 1;
        });

        return $item;
    }
}