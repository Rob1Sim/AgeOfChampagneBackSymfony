<?php

namespace App\Factory;

use App\Entity\Partenaire;
use App\Repository\PartenaireRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Partenaire>
 *
 * @method static Partenaire|Proxy                     createOne(array $attributes = [])
 * @method static Partenaire[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Partenaire[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Partenaire|Proxy                     find(object|array|mixed $criteria)
 * @method static Partenaire|Proxy                     findOrCreate(array $attributes)
 * @method static Partenaire|Proxy                     first(string $sortedField = 'id')
 * @method static Partenaire|Proxy                     last(string $sortedField = 'id')
 * @method static Partenaire|Proxy                     random(array $attributes = [])
 * @method static Partenaire|Proxy                     randomOrCreate(array $attributes = [])
 * @method static Partenaire[]|Proxy[]                 all()
 * @method static Partenaire[]|Proxy[]                 findBy(array $attributes)
 * @method static Partenaire[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 * @method static Partenaire[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static PartenaireRepository|RepositoryProxy repository()
 * @method        Partenaire|Proxy                     create(array|callable $attributes = [])
 */
final class PartenaireFactory extends ModelFactory
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
            'nom' => self::faker()->lastName(),
            'prenom' => self::faker()->name(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Partenaire $partenaire): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Partenaire::class;
    }
}
