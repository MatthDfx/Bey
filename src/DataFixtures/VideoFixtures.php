<?php

namespace App\DataFixtures;

use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $video1 = new Video();
        $video1->setUrl('https://www.youtube.com/embed/4aeDlZOD-B0');
        $manager->persist($video1);
        $video2 = new Video();
        $video2->setUrl('https://www.youtube.com/embed/kbMqWXnpXcA');
        $manager->persist($video2);
        $video3 = new Video();
        $video3->setUrl('https://www.youtube.com/embed/WDZJPJV__bQ');
        $manager->persist($video3);
        $video4 = new Video();
        $video4->setUrl('https://www.youtube.com/embed/civgUOommC8');
        $manager->persist($video4);
        $video5 = new Video();
        $video5->setUrl('https://www.youtube.com/embed/pZ12_E5R3qc');
        $manager->persist($video5);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
