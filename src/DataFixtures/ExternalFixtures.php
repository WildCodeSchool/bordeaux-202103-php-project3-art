<?php

namespace App\DataFixtures;

use App\Entity\ExternalArticle;
use App\Entity\ImageExternalArticle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExternalFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $article = new ExternalArticle();
        $image = new ImageExternalArticle();
        $image->setImage('exter1.jpg');
        $article->setTitle('ESS : quatre projets émergents distingués par Bordeaux Métropole')
            ->setLink('https://objectifaquitaine.latribune.fr/innovation/2020-12-08/ess-quatre-projets-emergents-distingues-par-bordeaux-metropole-864985.html')
            -> setImageExternalArticle($image);
        $manager->persist($article);

        $article = new ExternalArticle();
        $image = new ImageExternalArticle();
        $image->setImage('exter2.jpg');
        $article->setTitle('Kollecte')
            ->setLink('https://www.facebook.com/pg/artsdko/posts/')
            -> setImageExternalArticle($image);
        $manager->persist($article);

        $article = new ExternalArticle();
        $image = new ImageExternalArticle();
        $image->setImage('exter3.png');
        $article->setTitle('clubVie')
            ->setLink('https://www.clubvie.fr/article/lutter-contre-le-conditionnement-social-des-jeunes-talents-du-milieu-culturel-le-defi-d-estelle-jonathan-anciens-v-i-e/01/12/2020/1225')
            -> setImageExternalArticle($image);
        $manager->persist($article);

        $manager->flush();
    }
}
