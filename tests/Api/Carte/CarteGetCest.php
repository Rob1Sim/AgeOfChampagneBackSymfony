<?php

namespace App\Tests\Api\Carte;

use App\Entity\Carte;
use App\Factory\CarteFactory;
use App\Factory\CompteFactory;
use App\Factory\CruFactory;
use App\Factory\VigneronFactory;
use App\Tests\ApiTester;

class CarteGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'nom' => 'string',
            'type' => 'string',
            'region' => 'string',
            'latitude' => 'float',
            'longitude' => 'float',
            'superficie' => 'float',
            'cru_r' => 'string',
            'contenuImage' => 'string',
            'vigneronID' => 'integer',
        ];
    }

    public function getCarteByID(ApiTester $I): void
    {
        $data = [
            'login' => 'user1',
        ];
        $user = CompteFactory::createOne()->object();
        CompteFactory::createOne($data);
        $I->amLoggedInAs($user);

        $vignerons = VigneronFactory::createOne();
        $cru = CruFactory::createOne();
        CarteFactory::createOne([
            'nom' => 'test',
            'type' => 'test',
            'region' => 'test',
            'latitude' => 1.2,
            'longitude' => 1.3,
            'superficie' => 1.4,
            'cru_r' => $cru,
            'vignerons' => $vignerons,
        ]);

        $I->sendGet('/api/cartes/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Carte::class, '/api/cartes/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), [
            'nom' => 'test',
            'type' => 'test',
            'region' => 'test',
            'latitude' => 1.2,
            'longitude' => 1.3,
            'superficie' => 1.4,
            'vigneronID' => 1,
        ]);
    }

    public function getCarteCollection(ApiTester $I): void
    {
        $data = [
            'login' => 'user1',
        ];
        $user = CompteFactory::createOne()->object();
        CompteFactory::createOne($data);
        $I->amLoggedInAs($user);

        $vignerons = VigneronFactory::createOne();
        $cru = CruFactory::createOne();
        CarteFactory::createOne([
            'nom' => 'test',
            'type' => 'test',
            'region' => 'test',
            'latitude' => 1.2,
            'longitude' => 1.3,
            'superficie' => 1.4,
            'cru_r' => $cru,
            'vignerons' => $vignerons,
        ]);
        CarteFactory::createOne([
            'nom' => 'test',
            'type' => 'test',
            'region' => 'test',
            'latitude' => 1.2,
            'longitude' => 1.3,
            'superficie' => 1.4,
            'cru_r' => $cru,
            'vignerons' => $vignerons,
        ]);
        CarteFactory::createOne([
            'nom' => 'test',
            'type' => 'test',
            'region' => 'test',
            'latitude' => 1.2,
            'longitude' => 1.3,
            'superficie' => 1.4,
            'cru_r' => $cru,
            'vignerons' => $vignerons,
        ]);

        $I->sendGet('/api/cartes');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Carte::class, '/api/cartes', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(3, $jsonResponse['hydra:totalItems']);
        $I->assertCount(3, $jsonResponse['hydra:member']);
    }

    public function getCarteImage(ApiTester $I): void
    {
        $data = [
            'login' => 'user1',
        ];
        $user = CompteFactory::createOne()->object();
        CompteFactory::createOne($data);
        $I->amLoggedInAs($user);

        $cru = CruFactory::createOne();
        CarteFactory::createOne([
            'nom' => 'test',
            'cru_r' => $cru,
            'contenuImage' => 'AOC_VINEYARDS-CARDS_FR 43.5x67.5_DAMERY.png',
        ]);

        $I->sendGet('/api/cartes/1/image');
        $I->seeResponseCodeIsSuccessful();
    }
}
