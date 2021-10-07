<?php

namespace App\DataFixtures;

use App\Entity\Shape;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShapeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new Shape())->setName('triangle'));
        $manager->persist((new Shape())->setName('circle'));
        $manager->persist((new Shape())->setName('square'));
        $manager->persist((new Shape())->setName('rhombus'));

        for ($i = 0; $i < 10; $i++) {
            $shape = new Shape();
            $shape->setName('shape' . $i);
            $manager->persist($shape);
        }

        $manager->flush();
    }
}
