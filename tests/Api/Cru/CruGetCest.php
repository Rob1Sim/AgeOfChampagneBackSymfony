<?php

namespace App\Tests\Api\Cru;

use App\Entity\Cru;
use App\Factory\CruFactory;
use App\Factory\VigneronFactory;
use App\Tests\ApiTester;

class CruGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'libelle' => 'string',
            'horaire' => 'string',
            'image' => 'blob',
            // blob ou string
            'infos' => 'string',
        ];
    }

    public function getCruDetail(ApiTester $I): void
    {
        $vigneron = VigneronFactory::createOne();
        CruFactory::createOne([
            'libelle' => 'lib1',
            'horaire' => 'hor1',
            'image' => 'img1',
            'infos' => 'infos1',
            'vigneron' => $vigneron,
        ]);

        $dataGet = [
            'libelle' => 'lib1',
            'horaire' => 'hor1',
            'image' => 'img1',
            'infos' => 'infos1',
            'vigneron' => 1,
        ];

        $I->sendGet('/api/cru/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Cru::class, '/api/cru/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $dataGet);
    }
}