<?php

namespace App\DataFixtures;

use App\Entity\Gif;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GifFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $gif1 = new Gif();
        $gif1->setUrl('gif1.gif');
        $manager->persist($gif1);
        $gif2 = new Gif();
        $gif2->setUrl('gif2.gif');
        $manager->persist($gif2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
