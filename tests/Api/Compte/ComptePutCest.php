<?php

namespace App\Tests\Api\Compte;

use App\Entity\Compte;
use App\Factory\CompteFactory;
use App\Tests\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Codeception\Util\HttpCode;

class ComptePutCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'email' => 'string',
            'roles' => 'string',
            'date_naiss' => 'date',
            'login' => 'string',
        ];
    }

    public function anonymousUserForbiddenToPutUser(ApiTester $I): void
    {
        // 1. 'Arrange'
        CompteFactory::createOne();

        // 2. 'Act'
        $I->sendPut('/api/comptes/1');

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserForbiddenToPutOtherUser(ApiTester $I): void
    {
        // 1. 'Arrange'
        $user = CompteFactory::createOne()->object();
        CompteFactory::createOne();
        $I->amLoggedInAs($user);

        // 2. 'Act'
        $I->sendPut('/api/compte/2');

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

}
