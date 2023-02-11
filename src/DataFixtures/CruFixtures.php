<?php

namespace App\DataFixtures;

use App\Factory\CruFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CruFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CruFactory::createMany(10);
        $manager->flush();
    }
}
