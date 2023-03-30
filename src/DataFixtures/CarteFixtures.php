<?php

namespace App\DataFixtures;

use App\Entity\Carte;
use App\Entity\Compte;
use App\Factory\CarteFactory;
use App\Factory\CategoryFactory;
use App\Factory\CruFactory;
use App\Factory\VigneronFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CarteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): array
    {
        $carte = new Carte();
        $compte = new Compte();

        $cartes = CarteFactory::createMany(10, function () {
            return [
                'vignerons' => VigneronFactory::random(),
                'category' => CategoryFactory::random(),
                'cru_r' => CruFactory::random(),
            ];
        });
        foreach ($cartes as $relations) {
            return [
                $this->addReference('carte_compte', $compte),

                $relations->addCompte($compte),
                $compte->addCarte($carte),
            ];
        }
        $manager->persist($carte);
        $manager->persist($compte);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            VigneronFixtures::class,
            CompteFixtures::class,
            CategoryFixtures::class,
            CruFixtures::class,
        ];
    }
}
