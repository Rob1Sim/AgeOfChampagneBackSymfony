<?php

namespace App\Tests\Controller\Vigneron;

use App\Factory\CompteFactory;
use App\Factory\VigneronFactory;
use App\Tests\ControllerTester;

class VigneronCest
{
    public function testVigneronList(ControllerTester $V)
    {
        $user = CompteFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $trueUser = $user->object();
        $V->amLoggedInAs($trueUser);

        $V->amOnPage('/vigneron');
        $V->seeResponseCodeIsSuccessful();
        $V->seeInTitle('Liste des Vignerons');
        $V->see('Liste des Vignerons');
    }

    // Vérifie que nous sommes bien redirigés sur /login quand nous ne sommes pas connectés !
    public function restricted(ControllerTester $I)
    {
        VigneronFactory::createOne();
        $I->amOnPage('/vigneron/1');
        $I->seeCurrentUrlEquals('/login');
    }
}
