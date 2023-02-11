<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $Categories = json_decode(file_get_contents('src/DataFixtures/data/Category.json'), true);
        foreach ($Categories as $category) {
            CategoryFactory::createOne(['name' => $category['name']]);
        }
    }
}
