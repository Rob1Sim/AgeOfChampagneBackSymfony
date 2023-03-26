<?php

namespace App\Tests\Api\Compte;

use App\Entity\Compte;
use App\Factory\CompteFactory;
use App\Tests\ApiTester;

class CompteGetCest
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

    public function anonymousUserGetSimpleUserElement(ApiTester $I): void
    {
        // 1. 'Arrange'
        $data = [
            'login' => 'user1',
            'email' => 'user-1@example.fr',
        ];
        CompteFactory::createOne($data);

        // 2. 'Act'
        $I->sendGet('/api/comptes/1');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Compte::class, '/api/comptes/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $data);
    }
    

}
