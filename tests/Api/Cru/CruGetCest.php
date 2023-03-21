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
}
