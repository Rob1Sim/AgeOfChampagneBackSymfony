<?php

namespace App\Tests\Api\Compte;

use App\Entity\Compte;
use App\Factory\CompteFactory;
use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

class CompteGetMeCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'email' => 'string',
            'dateNaiss' => 'string',
            'login' => 'string',
            'cartes' => 'array',
        ];
    }

    public function anonymousMeIsUnauthorized(ApiTester $I): void
    {
        // 1. 'Arrange'
        CompteFactory::createOne();

        // 2. 'Act'
        $I->sendGet('/api/me');

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserOnMeGetData(ApiTester $I): void
    {
        // 1. 'Arrange'
        $user = CompteFactory::createOne()->object();
        CompteFactory::createOne();
        $I->amLoggedInAs($user);

        // 2. 'Act'
        $I->sendGet('/api/me');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Compte::class, '/api/me');
        $I->seeResponseIsAnItem(self::expectedProperties(), ['login' => $user->getLogin()]);
    }
}
