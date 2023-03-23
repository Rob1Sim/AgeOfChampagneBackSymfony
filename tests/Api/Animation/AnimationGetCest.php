<?php

namespace App\Tests\Api\Animation;

use App\Entity\Animation;
use App\Factory\AnimationFactory;
use App\Tests\ApiTester;

class AnimationGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'type' => 'string',
            'nom' => 'string',
            'prix' => 'float',
            'horaireDeb' => 'string',
            'horaireFin' => 'string',
            'contenuImage' => 'string',
        ];
    }

    public function getAnimationByID(ApiTester $I): void
    {
        $horaireDeb = new \DateTime();
        $horaireFin = new \DateTime();
        AnimationFactory::createOne([
            'type' => 'test',
            'nom' => 'test',
            'prix' => 19.6,
            'horaireDeb' => $horaireDeb,
            'horaireFin' => $horaireFin,
        ]);

        $I->sendGet('/api/animations/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Animation::class, '/api/animations/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), [
            'type' => 'test',
            'nom' => 'test',
            'prix' => 19.6,
            'horaireDeb' => null,
            'horaireFin' => null,
        ]);
    }

    public function getAnimationImage(ApiTester $I): void
    {
        AnimationFactory::createOne([
            'nom' => 'test',
            'contenuImage' => 'noanimation.png',
        ]);

        $I->sendGet('/api/animations/1/image');
        $I->seeResponseCodeIsSuccessful();
    }
}
