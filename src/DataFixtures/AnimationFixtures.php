<?php

namespace App\DataFixtures;

use App\Factory\AnimationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnimationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AnimationFactory::createMany(10);

        $manager->flush();
    }
}
