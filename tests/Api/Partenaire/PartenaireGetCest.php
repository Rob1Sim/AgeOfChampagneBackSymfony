<?php

namespace App\Tests\Api\Partenaire;

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
            'animationID' => 'integer',
        ];
    }

    public function getPartenaireByID(ApiTester $I): void
    {
        $animation = AnimationFactory::createOne();
        PartenaireFactory::createOne([
            'nom' => 'test',
            'prenom' => 'test',
            'animation' => $animation,
        ]);

        $I->sendGet('/api/partenaires/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Partenaire::class, '/api/partenaires/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), [
            'nom' => 'test',
            'prenom' => 'test',
            'animationID' => 1,
        ]);
    }
}
