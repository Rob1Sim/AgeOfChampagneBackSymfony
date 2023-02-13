<?php

namespace App\Tests\Api;

use App\Entity\Partenaire;
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
        ];
    }
}