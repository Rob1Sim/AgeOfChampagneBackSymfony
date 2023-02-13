<?php

namespace App\Tests\Api;

use App\Entity\Partenaire;
use App\Factory\AnimationFactory;
use App\Factory\PartenaireFactory;
use App\Tests\ApiTester;

class PartenaireGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'nom' => 'string',
            'prenom' => 'string',
        ];
    }

    public function getPartenaireByID(ApiTester $I): void
    {
        $animation = AnimationFactory::createOne();
        PartenaireFactory::createOne([
            'nom' => 'test',
            'prenom' => 'test',
        ]);

        $I->sendGet('/api/partenaires/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Partenaire::class, '/api/partenaires/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), [
            'nom' => 'test',
            'prenom' => 'test',
        ]);
    }
}
