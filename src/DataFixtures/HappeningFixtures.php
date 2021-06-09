<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\Discipline;
use App\Entity\Happening;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HappeningFixtures extends Fixture implements DependentFixtureInterface

{
    public function load(ObjectManager $manager)
    {
        $happening1 = new Happening();
        $happening1->setTitle('Pool Party');
        $happening1->setMedia('https://venngage-wordpress.s3.amazonaws.com/uploads/2018/10/Creative-Pool-Party-Event-Poster-Template.jpg');
        $happening1->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare risus a nibh ornare, condimentum finibus metus blandit. Etiam dignissim volutpat augue. Maecenas vel nisi ac leo porttitor luctus. Nam vel imperdiet velit. Pellentesque ac ipsum nisi. Aliquam interdum metus sed risus venenatis, at accumsan eros varius. Donec tincidunt rutrum imperdiet. Ut pretium nulla non elementum rhoncus.
Integer suscipit et turpis efficitur euismod. Aliquam rutrum ornare nibh. Proin in sodales sapien. Quisque maximus ante sed orci viverra, at facilisis nisi scelerisque. Nulla enim ipsum, sollicitudin ut velit vel, aliquam suscipit arcu. Phasellus maximus ullamcorper tincidunt. Duis mollis sem vel nisl cursus sodales. Integer nec mauris pretium nibh condimentum suscipit ac vitae purus. Donec id odio vitae mauris scelerisque tempor. Mauris iaculis, purus eu sodales tempor, erat arcu interdum nulla, nec consectetur orci orci non nunc. Proin faucibus placerat semper. Suspendisse potenti. Morbi eros sapien, convallis sit amet iaculis sit amet, egestas non odio. Duis ut tristique eros.');
        $happening1->setDateStart(new \DateTime());
        $happening1->setDateEnd(new \DateTime());
        $happening1->setCreatedAt(new \DateTime());
        $happening1->setUpdatedAt(new \DateTime());
        $happening1->setUser($this->getReference('user_1'));
        $manager->persist($happening1);

        $happening2 = new Happening();
        $happening2->setTitle('Jazz Festival');
        $happening2->setMedia('https://www.crushpixel.com/big-static12/preview4/vector-illustration-poster-flyer-design-1004277.jpg');
        $happening2->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare risus a nibh ornare, condimentum finibus metus blandit. Etiam dignissim volutpat augue. Maecenas vel nisi ac leo porttitor luctus. Nam vel imperdiet velit. Pellentesque ac ipsum nisi. Aliquam interdum metus sed risus venenatis, at accumsan eros varius. Donec tincidunt rutrum imperdiet. Ut pretium nulla non elementum rhoncus.
Integer suscipit et turpis efficitur euismod. Aliquam rutrum ornare nibh. Proin in sodales sapien. Quisque maximus ante sed orci viverra, at facilisis nisi scelerisque. Nulla enim ipsum, sollicitudin ut velit vel, aliquam suscipit arcu. Phasellus maximus ullamcorper tincidunt. Duis mollis sem vel nisl cursus sodales. Integer nec mauris pretium nibh condimentum suscipit ac vitae purus. Donec id odio vitae mauris scelerisque tempor. Mauris iaculis, purus eu sodales tempor, erat arcu interdum nulla, nec consectetur orci orci non nunc. Proin faucibus placerat semper. Suspendisse potenti. Morbi eros sapien, convallis sit amet iaculis sit amet, egestas non odio. Duis ut tristique eros.');
        $happening2->setDateStart(new \DateTime());
        $happening2->setDateEnd(new \DateTime());
        $happening2->setCreatedAt(new \DateTime());
        $happening2->setUpdatedAt(new \DateTime());
        $happening2->setUser($this->getReference('user_2'));
        $manager->persist($happening2);

        $happening3 = new Happening();
        $happening3->setTitle('Community PicNic');
        $happening3->setMedia('https://s3.amazonaws.com/thumbnails.venngage.com/template/112a39f4-2d97-44aa-ae3a-0e95a60abbce.png');
        $happening3->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare risus a nibh ornare, condimentum finibus metus blandit. Etiam dignissim volutpat augue. Maecenas vel nisi ac leo porttitor luctus. Nam vel imperdiet velit. Pellentesque ac ipsum nisi. Aliquam interdum metus sed risus venenatis, at accumsan eros varius. Donec tincidunt rutrum imperdiet. Ut pretium nulla non elementum rhoncus.
Integer suscipit et turpis efficitur euismod. Aliquam rutrum ornare nibh. Proin in sodales sapien. Quisque maximus ante sed orci viverra, at facilisis nisi scelerisque. Nulla enim ipsum, sollicitudin ut velit vel, aliquam suscipit arcu. Phasellus maximus ullamcorper tincidunt. Duis mollis sem vel nisl cursus sodales. Integer nec mauris pretium nibh condimentum suscipit ac vitae purus. Donec id odio vitae mauris scelerisque tempor. Mauris iaculis, purus eu sodales tempor, erat arcu interdum nulla, nec consectetur orci orci non nunc. Proin faucibus placerat semper. Suspendisse potenti. Morbi eros sapien, convallis sit amet iaculis sit amet, egestas non odio. Duis ut tristique eros.');
        $happening3->setDateStart(new \DateTime());
        $happening3->setDateEnd(new \DateTime());
        $happening3->setCreatedAt(new \DateTime());
        $happening3->setUpdatedAt(new \DateTime());
        $happening3->setUser($this->getReference('user_3'));
        $manager->persist($happening3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
