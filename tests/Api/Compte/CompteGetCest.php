<?php

namespace App\Tests\Api\Compte;

class CompteGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'email' => 'string',
            'roles' => 'string',
            'date_naiss' => 'date',
            'login' => 'string',
        ];
    }
}
