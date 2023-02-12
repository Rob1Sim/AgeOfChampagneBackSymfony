<?php

namespace App\Tests\Api;

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
            'surface' => 'float',
            'cru' => 'object?',
            'contenuImage' => 'string',
            'vigneronID' => 'integer',
        ];
    }
}
