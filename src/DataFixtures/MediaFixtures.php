<?php

namespace App\DataFixtures;

use App\Entity\ImageArtwork;
use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{
    public const MEDIA_LINKS = [
    'https://www.youtube.com/embed/eIBCd4zmPDA',
    'https://www.youtube.com/embed/W25W2jOmKUM',
    'https://www.youtube.com/embed/XNhfV_53W7A',
    'https://www.youtube.com/embed/SXfgixkt4-Q',
    'https://www.youtube.com/embed/tG-xwv0kw0',
    'https://www.youtube.com/embed/-kT0HJhm5ck',
    'https://www.youtube.com/embed/1jCh5XLGWEs',
    'https://www.youtube.com/embed/IXkG7SRtJJs',
    'https://www.youtube.com/embed/J78NMdKN5UQ',
    'https://www.youtube.com/embed/T19d8I4v1Gw',
    ];
    public const MEDIA_SUPPORTS = [
        Media::SUPPORT_CHOICE[0],
        Media::SUPPORT_CHOICE[0],
        Media::SUPPORT_CHOICE[0],
        Media::SUPPORT_CHOICE[0],
        Media::SUPPORT_CHOICE[0],
        Media::SUPPORT_CHOICE[0],
        Media::SUPPORT_CHOICE[0],
        Media::SUPPORT_CHOICE[0],
        Media::SUPPORT_CHOICE[0],
        Media::SUPPORT_CHOICE[0],
    ];
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < count(self::MEDIA_LINKS); $i++) {
            $media = new Media();
            $media->setUrl(self::MEDIA_LINKS[$i]);
            $media->setSupport(self::MEDIA_SUPPORTS[$i]);
            $media->setArtwork($this->getReference('artwork_' . $i));
            $manager->persist($media);
            $this->addReference('media_' . $i, $media);
        }
        for($i=1; $i <= 6; $i++){
            $imageArtwork = new ImageArtwork();
            $imageArtwork->setImage('book' . $i . '.jpg');
            $manager->persist($imageArtwork);
            $media = new Media();
            $media->setImageArtwork($imageArtwork);
            $media->setSupport('photo');
            $media->setArtwork($this->getReference('artwork_' . ($i + 9)));
            $manager->persist($media);
            $this->addReference('media_' . ($i + 9), $media);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return[
            ArtworkFixtures::class,
        ];
    }
}
