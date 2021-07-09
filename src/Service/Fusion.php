<?php

namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;

class Fusion
{
    public function goTenks(array $happenings, array $articles): array
    {
        $posts = new ArrayCollection(array_merge($happenings, $articles));
        $dates = [];
        $result = [];
        foreach ($posts as $key => $post) {
            $dates[$key] =  $post->getCreatedAt();
        }
        asort($dates);
        foreach ($dates as $key => $date) {
            $result[] = $posts[$key];
        }
        return $result;
    }
}
