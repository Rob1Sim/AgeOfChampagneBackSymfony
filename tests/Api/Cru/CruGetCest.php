<?php

namespace App\Tests\Api\Cru;

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
}