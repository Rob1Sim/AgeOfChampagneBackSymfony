<?php

namespace App\DataFixtures;

use App\Factory\AnimationFactory;
use App\Factory\PartenaireFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PartenaireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PartenaireFactory::createMany(10, function () {
            return [
                'animation' => AnimationFactory::random(),
            ];
        });
    }

    public function getDependencies(): array
    {
        return [
            AnimationFixtures::class,
        ];
    }
}
