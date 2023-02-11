<?php

namespace App\Tests\Controller\Vigneron;

use App\Factory\CompteFactory;
use App\Factory\VigneronFactory;
use App\Tests\ControllerTester;

class VigneronShowCest
{
    public function testVigneronShow(ControllerTester $I)
    {
        $user = CompteFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $trueUser = $user->object();
        $I->amLoggedInAs($trueUser);

        VigneronFactory::createOne(['nom' => 'Maton']);

        $I->amOnPage('/vigneron');
        $I->click('Maton');
        $I->seeCurrentRouteIs('app_vigneron_show');
    }
}
