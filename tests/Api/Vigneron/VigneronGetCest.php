<?php

namespace App\Tests\Api\Vigneron;

use App\Entity\Vigneron;
use App\Factory\CruFactory;
use App\Factory\ProduitFactory;
use App\Factory\VigneronFactory;
use App\Tests\ApiTester;

class VigneronGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'nom' => 'string',
            'prenom' => 'string',
            'adresse' => 'string',
            'code_postal' => 'string',
            'ville' => 'string',
            'cruID' => 'integer',
            'produitID' => 'integer',
            'contenuImage' => 'string',
        ];
    }

    public function getVigneronByID(ApiTester $I): void
    {
        $produit = ProduitFactory::createOne();
        $cru = CruFactory::createOne();
        VigneronFactory::createOne([
            'nom' => 'test',
            'prenom' => 'test',
            'adresse' => 'test',
            'code_postal' => 'test',
            'ville' => 'test',
            'cru' => $cru,
            'produit' => $produit,
        ]);

        $dataGet = [
            'nom' => 'test',
            'prenom' => 'test',
            'adresse' => 'test',
            'code_postal' => 'test',
            'ville' => 'test',
            'cruID' => 1,
            'produitID' => 1,
        ];

        $I->sendGet('/api/vignerons/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Vigneron::class, '/api/vignerons/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $dataGet);
    }

    public function getVigneronCollection(ApiTester $I): void
    {
        $produit = ProduitFactory::createOne();
        $cru = CruFactory::createOne();
        VigneronFactory::createOne([
            'nom' => 'test',
            'prenom' => 'test',
            'adresse' => 'test',
            'code_postal' => 'test',
            'ville' => 'test',
            'cru' => $cru,
            'produit' => $produit,
        ]);
        VigneronFactory::createOne([
            'nom' => 'test',
            'prenom' => 'test',
            'adresse' => 'test',
            'code_postal' => 'test',
            'ville' => 'test',
            'cru' => $cru,
            'produit' => $produit,
        ]);
        VigneronFactory::createOne([
            'nom' => 'test',
            'prenom' => 'test',
            'adresse' => 'test',
            'code_postal' => 'test',
            'ville' => 'test',
            'cru' => $cru,
            'produit' => $produit,
        ]);

        $I->sendGet('/api/vignerons');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Vigneron::class, '/api/vignerons', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(3, $jsonResponse['hydra:totalItems']);
        $I->assertCount(3, $jsonResponse['hydra:member']);
    }

    public function getVigneronImage(ApiTester $I): void
    {
        $produit = ProduitFactory::createOne();
        $cru = CruFactory::createOne();
        VigneronFactory::createOne([
            'nom' => 'test',
            'cru' => $cru,
            'produit' => $produit,
            'contenuImage' => 'noperson.png',
        ]);

        $I->sendGet('/api/vignerons/1/image');
        $I->seeResponseCodeIsSuccessful();
    }
}
