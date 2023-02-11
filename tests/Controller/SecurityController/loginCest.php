<?php

namespace App\Tests\Controller\SecurityController;

use App\Factory\CompteFactory;
use App\Tests\ControllerTester;

class loginCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function tryToTest(ControllerTester $I)
    {
        $user = CompteFactory::createOne(['email' => 'erwann.mutant@gmail.com', 'roles' => ['ROLE_ADMIN'], 'password' => 'test',  'login' => 'Erwann', 'isVerified' => true]);
        $realUser = $user->object();
        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful();
        $I->amLoggedInAs($realUser);
    }
}
