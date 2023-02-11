<?php

namespace App\Tests\Controller\Carte;

use App\Factory\CarteFactory;
use App\Factory\CategoryFactory;
use App\Factory\CompteFactory;
use App\Tests\ControllerTester;

class ListeCest
{
    // Vérifie que nous sommes bien redirigés sur /login quand nous ne sommes pas connectés !
    public function restricted(ControllerTester $I)
    {
        $I->logout();
        CarteFactory::createOne(['category' => CategoryFactory::createOne()]);
        $I->amOnPage('/carte');
        $I->seeCurrentUrlEquals('/login');
    }

    public function listeCartes(ControllerTester $I)
    {
        $user = CompteFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $trueUser = $user->object();
        $I->amLoggedInAs($trueUser);

        CarteFactory::createMany(10, ['category' => CategoryFactory::createOne()]);
        CarteFactory::createOne(['nom' => 'Aaaaaaaaaaaa', 'category' => CategoryFactory::createOne()]);
        $I->amOnPage('/carte');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des cartes');
        // 11 cartes dans ce test, et un crée dans le précédent
        $I->seeNumberOfElements('.carte', 12);
        $I->seeCurrentRouteIs('app_carte');
    }

    public function redirectToCarte(ControllerTester $I)
    {
        $user = CompteFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $trueUser = $user->object();
        $I->amLoggedInAs($trueUser);

        CarteFactory::createMany(5, ['category' => CategoryFactory::createOne()]);
        CarteFactory::createOne(['nom' => 'Aaaaaaaaaaaa', 'category' => CategoryFactory::createOne()]);
        $I->amOnPage('/carte');
        $I->seeResponseCodeIsSuccessful();
        $I->click('Aaaaaaaaaaaa');
        $I->seeCurrentRouteIs('app_carte_show');
    }
}
