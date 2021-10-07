<?php

namespace App\DataFixtures;

use App\Entity\Color;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ColorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new Color())->setName('red'));
        $manager->persist((new Color())->setName('blue'));
        $manager->persist((new Color())->setName('green'));
        $manager->persist((new Color())->setName('violet'));

        for ($i = 0; $i < 10; $i++) {
            $color = new Color();
            $color->setName('color' . $i);
            $manager->persist($color);
        }

        $manager->flush();
    }
}
