<?php

namespace App\Tests\Api\Compte;

use App\Entity\Compte;
use App\Factory\CompteFactory;
use App\Tests\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Codeception\Util\HttpCode;

class ComptePatchCest
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

    public function anonymousUserForbiddenToPatchUser(ApiTester $I): void
    {
        // 1. 'Arrange'
        CompteFactory::createOne();

        // 2. 'Act'
        $I->sendPatch('/api/comptes/1');

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserForbiddenToPatchOtherUser(ApiTester $I): void
    {
        // 1. 'Arrange'
        $user = CompteFactory::createOne()->object();
        CompteFactory::createOne();
        $I->amLoggedInAs($user);

        // 2. 'Act'
        $I->sendPatch('/api/comptes/2');

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedUserCanPatchOwnData(ApiTester $I): void
    {
        // 1. 'Arrange'
        $dataInit = [
            'login' => 'user1',
            'email' => 'user-1@example.fr',
        ];

        $user = CompteFactory::createOne($dataInit)->object();
        $I->amLoggedInAs($user);

        // 2. 'Act'
        $dataPatch = [
            'login' => 'user2',
            'email' => 'user-2@example.fr',
        ];
        $I->sendPatch('/api/comptes/1', $dataPatch);

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Compte::class, '/api/comptes/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $dataPatch);
    }

    public function authenticatedUserCanChangeHisPassword(ApiTester $I): void
    {
        // 1. 'Arrange'
        $dataInit = [
            'login' => 'user1',
            'password' => 'password',
        ];
        $user = CompteFactory::createOne($dataInit)->object();
        $I->amLoggedInAs($user);

        // 2. 'Act'
        $dataPatch = ['password' => 'new password'];
        $I->sendPatch('/api/comptes/1', $dataPatch);

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Compte::class, '/api/comptes/1');
        $I->seeResponseIsAnItem(self::expectedProperties());

        $I->amOnPage('/logout');
        // Don't check response code since homepage is not configured (404)
        // $I->seeResponseCodeIsSuccessful();
        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful();
        $I->submitForm(
            'form',
            ['login' => 'user1', 'password' => 'new password'],
            'Authentification'
        );
        $I->seeResponseCodeIsSuccessful();
        $I->seeInCurrentUrl('/api/docs');
    }

    protected function invalidDataLeadsToUnprocessableEntityProvider(): array
    {
        return [
            ['property' => 'login', 'value' => '<&">'],
            ['property' => 'email', 'value' => 'badmail'],
        ];
    }

    #[DataProvider('invalidDataLeadsToUnprocessableEntityProvider')]
    public function invalidDataLeadsToUnprocessableEntity(ApiTester $I, Example $example): void
    {
        // 1. 'Arrange'
        $user = CompteFactory::createOne()->object();
        $I->amLoggedInAs($user);

        // 2. 'Act'
        $dataPut = [
            $example['property'] => $example['value'],
        ];
        $I->sendPut('/api/comptes/1', $dataPut);

        // 3. 'Assert'
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
    }
}
