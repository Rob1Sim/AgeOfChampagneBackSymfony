<?php

namespace App\Tests\Controller\Animation;

use App\Factory\AnimationFactory;
use App\Factory\CompteFactory;
use App\Tests\ControllerTester;

class ListeCest
{
    public function listeAnim(ControllerTester $I)
    {
        $user = CompteFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $trueUser = $user->object();
        $I->amLoggedInAs($trueUser);

        AnimationFactory::createMany(10);
        AnimationFactory::createOne(['nom' => 'Giga Fiesta']);
        $I->amOnPage('/animation');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des Animations');
        $I->seeNumberOfElements('.show-vigneron-body', 11);
        $I->seeCurrentRouteIs('app_animation');
    }
}
