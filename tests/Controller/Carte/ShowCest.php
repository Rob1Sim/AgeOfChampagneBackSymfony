<?php

namespace App\Tests\Controller\Carte;

use App\Factory\CarteFactory;
use App\Factory\CategoryFactory;
use App\Factory\CompteFactory;
use App\Tests\ControllerTester;

class ShowCest
{
    public function showCarte(ControllerTester $I)
    {
        $user = CompteFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $trueUser = $user->object();
        $I->amLoggedInAs($trueUser);
        CarteFactory::createOne(['nom' => 'Aaaaaaaaaaaa', 'category' => CategoryFactory::createOne()]);

        $I->amOnPage('/carte');
        $I->click('Aaaaaaaaaaaa');
        $I->seeCurrentRouteIs('app_carte_show');
    }
}
