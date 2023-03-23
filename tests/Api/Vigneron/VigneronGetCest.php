<?php

namespace App\Tests\Api\Vigneron;

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
}