<?php

namespace App\Tests\Api;

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
}
