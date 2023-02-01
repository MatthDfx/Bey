<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $picture1 = new Picture();
        $picture1->setPoster('picture1.jpg');
        $manager->persist($picture1);
        $picture2 = new Picture();
        $picture2->setPoster('picture2.jpg');
        $manager->persist($picture2);
        $picture3 = new Picture();
        $picture3->setPoster('picture3.jpg');
        $manager->persist($picture3);
        $picture4 = new Picture();
        $picture4->setPoster('picture4.jpg');
        $manager->persist($picture4);
        $picture5 = new Picture();
        $picture5->setPoster('picture5.jpg');
        $manager->persist($picture5);
        $picture6 = new Picture();
        $picture6->setPoster('picture6.jpg');
        $manager->persist($picture6);
        $picture7 = new Picture();
        $picture7->setPoster('picture7.jpg');
        $manager->persist($picture7);
        $picture8 = new Picture();
        $picture8->setPoster('picture8.jpg');
        $manager->persist($picture8);
        $picture9 = new Picture();
        $picture9->setPoster('picture9.jpg');
        $manager->persist($picture9);
        $picture10 = new Picture();
        $picture10->setPoster('picture10.jpg');
        $manager->persist($picture10);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
