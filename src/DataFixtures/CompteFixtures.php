<?php

namespace App\DataFixtures;

use App\Factory\CompteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        CompteFactory::createOne(['email' => 'root@example.fr', 'roles' => ['ROLE_ADMIN'], 'login' => 'Admin']);
        CompteFactory::createOne(['email' => 'user-lambda@example.fr', 'roles' => ['ROLE_USER'], 'login' => 'UserLambda']);
        CompteFactory::createOne(['email' => 'user-premium@example.fr', 'roles' => ['ROLE_PREMIUM'], 'login' => 'UserPremium']);
        CompteFactory::createMany(10, ['roles' => ['ROLE_USER']]);
        CompteFactory::createMany(10, ['roles' => ['ROLE_PREMIUM']]);

        $manager->flush();
    }
}
