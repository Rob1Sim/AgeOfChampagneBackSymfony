<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use App\Entity\Compte;
use App\Factory\CompteFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Config\SecurityConfig;

// the name of the command is what users type after "php bin/console"
#[AsCommand(
    name: 'app:create-user',
    description: 'Créer un nouvel utilisateur.',
    aliases: ['app:add-user'],
    hidden: false
)]
class CreateUserCommand extends Command
{
    private string $mdp = '';
    private string $email = '';
    private string $role = '';
    private EntityManagerInterface $entityManager;
    private string $finalRole = 'ROLE_USER';

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (null != $this->email && '' != $this->email && null != $this->mdp && '' != $this->mdp && null != $this->role && '' != $this->role) {
            if ('admin' == $this->role) {
                $this->finalRole = 'ROLE_ADMIN';
            } elseif ('premium' == $this->role) {
                $this->finalRole = 'ROLE_PREMIUM';
            }
            CompteFactory::createOne(['email' => $this->email, 'roles' => [$this->finalRole], 'login' => $this->role]);
            $security = new SecurityConfig();
            $security->passwordHasher(Compte::class);

            $this->createUser($security);

            return Command::SUCCESS;
        } else {
            return Command::INVALID;
        }

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }

    protected function createUser(UserPasswordHasherInterface $passwordHasher)
    {
        $user = new Compte();

        $password = $passwordHasher->hashPassword($user, $this->mdp);
        $user->setPassword($password);
        $user->setLogin($this->role);
        $user->setEmail($this->email);
        $user->setRoles([$this->finalRole]);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('Email', InputArgument::REQUIRED, "Email de l'utilisateur")
            ->addArgument('mot de passe', InputArgument::REQUIRED, "Mot de passe de l'utilisateur")
            ->addArgument('Rôle', InputArgument::REQUIRED, "Rôle de l'utilisateur(admin,premium,user")
            ->setHelp('Email, mot de passe, rôle')
        ;
    }
}
