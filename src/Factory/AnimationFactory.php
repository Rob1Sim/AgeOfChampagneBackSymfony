<?php

namespace App\Factory;

use App\Entity\Animation;
use App\Repository\AnimationRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Animation>
 *
 * @method static Animation|Proxy                     createOne(array $attributes = [])
 * @method static Animation[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Animation[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Animation|Proxy                     find(object|array|mixed $criteria)
 * @method static Animation|Proxy                     findOrCreate(array $attributes)
 * @method static Animation|Proxy                     first(string $sortedField = 'id')
 * @method static Animation|Proxy                     last(string $sortedField = 'id')
 * @method static Animation|Proxy                     random(array $attributes = [])
 * @method static Animation|Proxy                     randomOrCreate(array $attributes = [])
 * @method static Animation[]|Proxy[]                 all()
 * @method static Animation[]|Proxy[]                 findBy(array $attributes)
 * @method static Animation[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 * @method static Animation[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static AnimationRepository|RepositoryProxy repository()
 * @method        Animation|Proxy                     create(array|callable $attributes = [])
 */
final class AnimationFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $jsonImage = file_get_contents('src/Factory/data/animation.json');
        $tableauImg = json_decode($jsonImage, true);

        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'type' => self::faker()->name(),
            'nom' => self::faker()->name(),
            'prix' => self::faker()->randomFloat(),
            'horaireDeb' => self::faker()->dateTime(),
            'horaireFin' => self::faker()->dateTime(),
            'contenuImage' => $tableauImg[array_rand($tableauImg)],
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Animation $animation): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Animation::class;
    }
}
