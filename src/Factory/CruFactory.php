<?php

namespace App\Factory;

use App\Entity\Cru;
use App\Repository\CruRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Cru>
 *
 * @method static Cru|Proxy                     createOne(array $attributes = [])
 * @method static Cru[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Cru[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Cru|Proxy                     find(object|array|mixed $criteria)
 * @method static Cru|Proxy                     findOrCreate(array $attributes)
 * @method static Cru|Proxy                     first(string $sortedField = 'id')
 * @method static Cru|Proxy                     last(string $sortedField = 'id')
 * @method static Cru|Proxy                     random(array $attributes = [])
 * @method static Cru|Proxy                     randomOrCreate(array $attributes = [])
 * @method static Cru[]|Proxy[]                 all()
 * @method static Cru[]|Proxy[]                 findBy(array $attributes)
 * @method static Cru[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 * @method static Cru[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static CruRepository|RepositoryProxy repository()
 * @method        Cru|Proxy                     create(array|callable $attributes = [])
 */
final class CruFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'libelle' => self::faker()->company(),
            'horaire' => self::faker()->time(),
            'infos' => self::faker()->text(100),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Cru $cru): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Cru::class;
    }
}
