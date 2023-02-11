<?php

namespace App\Tests\Controller\RegistrationController;

use App\Tests\ControllerTester;

class registerCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function tryToTest(ControllerTester $I)
    {
        $I->amOnPage('/register');
        $I->seeResponseCodeIsSuccessful();
        $I->fillField('Identifiant', 'test');
        $I->fillField('Adresse Mail', 'test@gmail.com');
        $I->fillField('Date de naissance', '09/07/2002');
        $I->fillField('Mot de passe', 'test');
        $I->click("S'inscrire");
        $I->seeResponseCodeIsSuccessful();
    }
}
