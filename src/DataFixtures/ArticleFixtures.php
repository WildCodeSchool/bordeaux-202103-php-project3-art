<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ImageArticle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article = new Article();
        $image = new ImageArticle();
        $image->setImage('profile5.jpg');
        $manager->persist($image);
        $article->setTitle("Article1")
            ->setContent('Constituendi autem sunt qui sint in amicitia fines et quasi termini diligendi. De quibus tres video sententias ferri, quarum nullam probo, unam, ut eodem modo erga amicum adfecti simus, quo erga nosmet ipsos, alteram, ut nostra in amicos benevolentia illorum erga nos benevolentiae pariter aequaliterque respondeat, tertiam, ut, quanti quisque se ipse facit, tanti fiat ab amicis.')
            ->setImageArticle($image)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setUser($this->getReference('admin'));
         $manager->persist($article);

        $manager->flush();
    }
//
    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
