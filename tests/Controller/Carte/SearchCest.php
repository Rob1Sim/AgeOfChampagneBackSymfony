<?php

namespace App\Tests\Controller\Carte;

use App\Factory\CarteFactory;
use App\Factory\CategoryFactory;
use App\Factory\CompteFactory;
use App\Tests\ControllerTester;

class SearchCest
{
    public function search(ControllerTester $I)
    {
        $user = CompteFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $trueUser = $user->object();
        $I->amLoggedInAs($trueUser);

        /*
         * Création de 5 cartes dont :
         * - 3 contiennent un xxxxx
         * - 3 contiennent un yyyyy
         * - 2 contiennent un zzzzz
         * - Aucune ne contient de ooooo
         */
        CarteFactory::createOne(['nom' => 'xxxxx', 'category' => CategoryFactory::createOne()]);
        CarteFactory::createOne(['nom' => 'yyyyy', 'category' => CategoryFactory::createOne()]);
        CarteFactory::createOne(['nom' => 'zzzzz', 'category' => CategoryFactory::createOne()]);
        CarteFactory::createOne(['nom' => 'xxxxxyyyyy', 'category' => CategoryFactory::createOne()]);
        CarteFactory::createOne(['nom' => 'xxxxxyyyyyzzzzz', 'category' => CategoryFactory::createOne()]);
        $I->amOnPage('/carte?search=zzzzz');

        // +1 car le test inclut également les cartes récemment visitées
        $I->seeNumberOfElements('.carte', 2 + 1);
        $I->amOnPage('/carte?search=yyyyy');
        $I->seeNumberOfElements('.carte', 3 + 1);
        $I->amOnPage('/carte?search=xxxxx');
        $I->seeNumberOfElements('.carte', 3 + 1);
        $I->amOnPage('/carte?search=ooooo');
        $I->seeNumberOfElements('.carte', 0 + 1);
    }
}
