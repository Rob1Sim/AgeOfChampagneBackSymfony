<?php

namespace App\Tests\Api\Cru;

use App\Entity\Cru;
use App\Factory\CruFactory;
use App\Tests\ApiTester;

class CruGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'libelle' => 'string',
            'horaire' => 'string',
            'infos' => 'string',
        ];
    }

    public function getCruDetail(ApiTester $I): void
    {
        CruFactory::createOne([
            'libelle' => 'lib1',
            'horaire' => 'hor1',
            'infos' => 'infos1',
        ]);

        $dataGet = [
            'libelle' => 'lib1',
            'horaire' => 'hor1',
            'infos' => 'infos1',
        ];

        $I->sendGet('/api/crus/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Cru::class, '/api/crus/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $dataGet);
    }

    public function getCruCollection(ApiTester $I): void
    {
        CruFactory::createMany(3);

        $I->sendGet('/api/crus');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Cru::class, '/api/crus', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(3, $jsonResponse['hydra:totalItems']);
        $I->assertCount(3, $jsonResponse['hydra:member']);
    }
}
