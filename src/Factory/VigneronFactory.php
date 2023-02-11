<?php

namespace App\Factory;

use App\Entity\Vigneron;
use App\Repository\VigneronRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Vigneron>
 *
 * @method static Vigneron|Proxy                     createOne(array $attributes = [])
 * @method static Vigneron[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Vigneron[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Vigneron|Proxy                     find(object|array|mixed $criteria)
 * @method static Vigneron|Proxy                     findOrCreate(array $attributes)
 * @method static Vigneron|Proxy                     first(string $sortedField = 'id')
 * @method static Vigneron|Proxy                     last(string $sortedField = 'id')
 * @method static Vigneron|Proxy                     random(array $attributes = [])
 * @method static Vigneron|Proxy                     randomOrCreate(array $attributes = [])
 * @method static Vigneron[]|Proxy[]                 all()
 * @method static Vigneron[]|Proxy[]                 findBy(array $attributes)
 * @method static Vigneron[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 * @method static Vigneron[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static VigneronRepository|RepositoryProxy repository()
 * @method        Vigneron|Proxy                     create(array|callable $attributes = [])
 */
final class VigneronFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $jsonImage = file_get_contents('src/Factory/data/vigneron.json');
        $tableauImg = json_decode($jsonImage, true);

        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'nom' => self::faker()->lastName(),
            'prenom' => self::faker()->firstName(),
            'adresse' => self::faker()->address(),
            'code_postal' => self::faker()->numberBetween(10000, 99999),
            'ville' => self::faker()->city(),
            'contenuImage' => $tableauImg[array_rand($tableauImg)],
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Vigneron $vigneron): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Vigneron::class;
    }
}
