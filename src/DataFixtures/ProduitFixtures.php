<?php

namespace App\DataFixtures;

use App\Factory\ProduitFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ProduitFactory::createMany(10);
        $manager->flush();
    }
}
