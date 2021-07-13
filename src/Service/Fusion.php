<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Happening;
use Doctrine\Common\Collections\ArrayCollection;

class Fusion
{
    public function goTenks(array $happenings, array $articles): array
    {
        $posts = array_merge($happenings, $articles);
        uasort($posts,function($a, $b){
            if($a->getCreatedAt() === $b->getCreatedAt()) {
                return 0;
            }
            return ($a < $b) ? 1 : -1;
        });
        return $posts;
    }
}
