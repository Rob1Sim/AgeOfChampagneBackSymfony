<?php

namespace App\Factory;

use App\Entity\Compte;
use App\Repository\CompteRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Compte>
 *
 * @method static Compte|Proxy                     createOne(array $attributes = [])
 * @method static Compte[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Compte[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Compte|Proxy                     find(object|array|mixed $criteria)
 * @method static Compte|Proxy                     findOrCreate(array $attributes)
 * @method static Compte|Proxy                     first(string $sortedField = 'id')
 * @method static Compte|Proxy                     last(string $sortedField = 'id')
 * @method static Compte|Proxy                     random(array $attributes = [])
 * @method static Compte|Proxy                     randomOrCreate(array $attributes = [])
 * @method static Compte[]|Proxy[]                 all()
 * @method static Compte[]|Proxy[]                 findBy(array $attributes)
 * @method static Compte[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 * @method static Compte[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static CompteRepository|RepositoryProxy repository()
 * @method        Compte|Proxy                     create(array|callable $attributes = [])
 */
final class CompteFactory extends ModelFactory
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        $this->passwordHasher = $passwordHasher;
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'email' => self::faker()->unique()->numerify('user-####').'@example.fr',
            'roles' => [],
            'password' => 'test',
            'dateNaiss' => self::faker()->dateTimeBetween(),
            'login' => self::faker()->firstName(),
            'isVerified' => true,
        ];
    }

    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (Compte $user) {
                $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            })
        ;
    }

    protected static function getClass(): string
    {
        return Compte::class;
    }
}
