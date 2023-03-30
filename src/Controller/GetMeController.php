<?php

namespace App\Controller;

use Symfony\Component\Security\Core\User\UserInterface;

class GetMeController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function __invoke(): UserInterface
    {
        if (null === $this->getUser()) {
            $this->createNotFoundException('Utilisateur incorrecte');
        }

        return $this->getUser();
    }
}
