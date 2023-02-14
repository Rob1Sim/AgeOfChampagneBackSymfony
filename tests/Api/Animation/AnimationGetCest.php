<?php

namespace Api\Animation;

use App\Entity\Animation;

class AnimationGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'type' => 'string',
            'nom' => 'string',
            'horaireDeb' => '\DateTimeInterface',
            'horaireFin' => '\DateTimeInterface',
            'prix' => 'float',
            'contenuImage' => 'string',
        ];
    }


}
