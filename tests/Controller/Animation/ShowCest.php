<?php

namespace App\Tests\Controller\Animation;

use App\Factory\AnimationFactory;
use App\Factory\CompteFactory;
use App\Tests\ControllerTester;

class ShowCest
{
    public function showAnim(ControllerTester $I)
    {
        $user = CompteFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $trueUser = $user->object();
        $I->amLoggedInAs($trueUser);
        AnimationFactory::createOne(['nom' => 'Feur Party']);

        $I->amOnPage('/animation');
        $I->click('Feur Party');
        $I->seeCurrentRouteIs('app_animation_show');
    }
}
