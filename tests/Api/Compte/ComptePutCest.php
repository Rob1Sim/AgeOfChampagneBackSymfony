<?php

namespace App\Tests\Api\Compte;

use App\Entity\Compte;
use App\Factory\CompteFactory;
use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

class ComptePutCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'login' => 'string',
            'roles' => 'array',
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
        $I->sendPut('/api/comptes/2');

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedUserCanPutOwnData(ApiTester $I): void
    {
        // 1. 'Arrange'
        $dataInit = [
            'login' => 'user1',
            'password' => 'password',
        ];

        $user = CompteFactory::createOne($dataInit)->object();
        $I->amLoggedInAs($user);

        // 2. 'Act'
        $dataPut = [
            'login' => 'user2',
        ];

        $I->sendPut('/api/comptes/1', $dataPut);

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Compte::class, '/api/comptes/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $dataPut);
    }

    public function authenticatedUserCanChangeHisPassword(ApiTester $I): void
    {
        // 1. 'Arrange'
        $dataInit = [
            'login' => 'user',
            'password' => 'password',
        ];

        $user = CompteFactory::createOne($dataInit)->object();
        $I->amLoggedInAs($user);

        // 2. 'Act'
        $dataPut = ['password' => 'new password'];
        $I->sendPut('/api/comptes/1', $dataPut);

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Compte::class, '/api/comptes/1');
        $I->seeResponseIsAnItem(self::expectedProperties());

        // 2. 'Act'
        $I->amOnPage('/logout');
        // Don't check response code since homepage is not configured (404)
        // $I->seeResponseCodeIsSuccessful();
        $I->amOnRoute('app_login');
        $I->seeResponseCodeIsSuccessful();
        $I->submitForm(
            'form',
            ['login' => 'user1', 'password' => 'new password'],
            'Authentification'
        );
        $I->seeResponseCodeIsSuccessful();
    }
}
