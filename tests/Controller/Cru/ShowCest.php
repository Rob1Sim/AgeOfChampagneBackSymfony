<?php

namespace App\Tests\Controller\Cru;

use App\Factory\CompteFactory;
use App\Factory\CruFactory;
use App\Tests\ControllerTester;

class ShowCest
{
    public function testCruShow(ControllerTester $I)
    {
        $user = CompteFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $trueUser = $user->object();
        $I->amLoggedInAs($trueUser);

        CruFactory::createOne(['libelle' => 'Szczpeniak']);

        $I->amOnPage('/cru/1');
        $I->seeCurrentRouteIs('app_cru_show');
    }
}
