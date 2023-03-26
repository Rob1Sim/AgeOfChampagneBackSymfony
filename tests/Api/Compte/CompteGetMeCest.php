<?php

namespace App\Tests\Api\Compte;

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
            'roles' => 'string',
            'date_naiss' => 'date',
            'login' => 'string',
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
}
