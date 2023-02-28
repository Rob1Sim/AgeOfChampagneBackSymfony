<?php

namespace App\Tests\Api\Produit;

use App\Entity\Produit;
use App\Factory\ProduitFactory;
use App\Tests\ApiTester;

class ProduitGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'libelle' => 'string',
            'prix' => 'float',
        ];
    }

    public function getProduitByID(ApiTester $I): void
    {
        ProduitFactory::createOne([
            'libelle' => 'truc',
            'prix' => 19.6,
        ]);

        $I->sendGet('/api/produits/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Produit::class, '/api/produits/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), [
            'libelle' => 'truc',
            'prix' => 19.6,
        ]);
    }
}
