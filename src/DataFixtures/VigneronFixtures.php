<?php

namespace App\DataFixtures;

use App\Factory\AnimationFactory;
use App\Factory\CruFactory;
use App\Factory\PartenaireFactory;
use App\Factory\ProduitFactory;
use App\Factory\VigneronFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VigneronFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        VigneronFactory::createMany(10, function () {
            return [
                'cru' => CruFactory::random(),
                'produit' => ProduitFactory::random(),
                'animation' => AnimationFactory::randomRange(1, 3),
                'partenaire' => PartenaireFactory::randomRange(1, 3),
            ];
        });
    }

    public function getDependencies(): array
    {
        return [
            ProduitFixtures::class,
            CruFixtures::class,
            AnimationFixtures::class,
            PartenaireFixtures::class,
        ];
    }
}
