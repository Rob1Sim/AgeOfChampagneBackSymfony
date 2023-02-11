<?php

namespace App\Controller;

use App\Entity\Compte;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class MailerController extends AbstractController
{
    #[Route('/email', name: 'app_mailer')]
    public function sendEmail(MailerInterface $mailer, VerifyEmailHelperInterface $verifyEmailHelper, Compte $user): Response
    {
        $signatureComponents = $verifyEmailHelper->generateSignature(
            'app_verify_email',
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );
        $email = (new Email())
            ->from('contact@oldhengames.com')
            ->to('erwann.mutant@gmail.com')
            ->subject('Vérifier votre compte')
            ->text("Bonjour {$user->getLogin()} !")
            ->text('Comfirmer votre email sur :  '.$signatureComponents->getSignedUrl());
        $mailer->send($email);

        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }
}
