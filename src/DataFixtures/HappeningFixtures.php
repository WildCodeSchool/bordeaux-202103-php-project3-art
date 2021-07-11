<?php

namespace App\DataFixtures;

use App\Entity\Happening;
use App\Entity\ImageHappening;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HappeningFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $image = new ImageHappening();
        $image->setImage('happening_1.jpg');
        $happening1 = new Happening();
        $happening1->setImageHappening($image);
        $happening1->setTitle('Pool Party');
        $happening1->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare risus a nibh ornare, condimentum finibus metus blandit. Etiam dignissim volutpat augue. Maecenas vel nisi ac leo porttitor luctus. Nam vel imperdiet velit. Pellentesque ac ipsum nisi. Aliquam interdum metus sed risus venenatis, at accumsan eros varius. Donec tincidunt rutrum imperdiet. Ut pretium nulla non elementum rhoncus.
Integer suscipit et turpis efficitur euismod. Aliquam rutrum ornare nibh. Proin in sodales sapien. Quisque maximus ante sed orci viverra, at facilisis nisi scelerisque. Nulla enim ipsum, sollicitudin ut velit vel, aliquam suscipit arcu. Phasellus maximus ullamcorper tincidunt. Duis mollis sem vel nisl cursus sodales. Integer nec mauris pretium nibh condimentum suscipit ac vitae purus. Donec id odio vitae mauris scelerisque tempor. Mauris iaculis, purus eu sodales tempor, erat arcu interdum nulla, nec consectetur orci orci non nunc. Proin faucibus placerat semper. Suspendisse potenti. Morbi eros sapien, convallis sit amet iaculis sit amet, egestas non odio. Duis ut tristique eros.');
        $happening1->setUser($this->getReference('user_1'));
        $happening1->setDateStart(new \DateTime());
        $happening1->setDateEnd(new \DateTime());
        $manager->persist($happening1);

        $image = new ImageHappening();
        $image->setImage('happening_2.png');
        $happening2 = new Happening();
        $happening2->setImageHappening($image);
        $happening2->setTitle('Live, Art & Music');
        $happening2->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare risus a nibh ornare, condimentum finibus metus blandit. Etiam dignissim volutpat augue. Maecenas vel nisi ac leo porttitor luctus. Nam vel imperdiet velit. Pellentesque ac ipsum nisi. Aliquam interdum metus sed risus venenatis, at accumsan eros varius. Donec tincidunt rutrum imperdiet. Ut pretium nulla non elementum rhoncus.
Integer suscipit et turpis efficitur euismod. Aliquam rutrum ornare nibh. Proin in sodales sapien. Quisque maximus ante sed orci viverra, at facilisis nisi scelerisque. Nulla enim ipsum, sollicitudin ut velit vel, aliquam suscipit arcu. Phasellus maximus ullamcorper tincidunt. Duis mollis sem vel nisl cursus sodales. Integer nec mauris pretium nibh condimentum suscipit ac vitae purus. Donec id odio vitae mauris scelerisque tempor. Mauris iaculis, purus eu sodales tempor, erat arcu interdum nulla, nec consectetur orci orci non nunc. Proin faucibus placerat semper. Suspendisse potenti. Morbi eros sapien, convallis sit amet iaculis sit amet, egestas non odio. Duis ut tristique eros.');
        $happening2->setUser($this->getReference('user_2'));
        $happening2->setDateStart(new \DateTime());
        $happening2->setDateEnd(new \DateTime());
        $manager->persist($happening2);

        $image = new ImageHappening();
        $image->setImage('happening_3.png');
        $happening3 = new Happening();
        $happening3->setImageHappening($image);
        $happening3->setTitle('Community PicNic');
        $happening3->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare risus a nibh ornare, condimentum finibus metus blandit. Etiam dignissim volutpat augue. Maecenas vel nisi ac leo porttitor luctus. Nam vel imperdiet velit. Pellentesque ac ipsum nisi. Aliquam interdum metus sed risus venenatis, at accumsan eros varius. Donec tincidunt rutrum imperdiet. Ut pretium nulla non elementum rhoncus.
Integer suscipit et turpis efficitur euismod. Aliquam rutrum ornare nibh. Proin in sodales sapien. Quisque maximus ante sed orci viverra, at facilisis nisi scelerisque. Nulla enim ipsum, sollicitudin ut velit vel, aliquam suscipit arcu. Phasellus maximus ullamcorper tincidunt. Duis mollis sem vel nisl cursus sodales. Integer nec mauris pretium nibh condimentum suscipit ac vitae purus. Donec id odio vitae mauris scelerisque tempor. Mauris iaculis, purus eu sodales tempor, erat arcu interdum nulla, nec consectetur orci orci non nunc. Proin faucibus placerat semper. Suspendisse potenti. Morbi eros sapien, convallis sit amet iaculis sit amet, egestas non odio. Duis ut tristique eros.');
        $happening3->setUser($this->getReference('user_3'));
        $happening3->setDateStart(new \DateTime());
        $happening3->setDateEnd(new \DateTime());
        $manager->persist($happening3);

        $image = new ImageHappening();
        $image->setImage('happening_4.jpeg');
        $happening4 = new Happening();
        $happening4->setImageHappening($image);
        $happening4->setTitle('Fun Fest');
        $happening4->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare risus a nibh ornare, condimentum finibus metus blandit. Etiam dignissim volutpat augue. Maecenas vel nisi ac leo porttitor luctus. Nam vel imperdiet velit. Pellentesque ac ipsum nisi. Aliquam interdum metus sed risus venenatis, at accumsan eros varius. Donec tincidunt rutrum imperdiet. Ut pretium nulla non elementum rhoncus.
Integer suscipit et turpis efficitur euismod. Aliquam rutrum ornare nibh. Proin in sodales sapien.');
        $happening4->setUser($this->getReference('user_3'));
        $happening4->setDateStart(new \DateTime());
        $happening4->setDateEnd(new \DateTime());

        $manager->persist($happening4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
