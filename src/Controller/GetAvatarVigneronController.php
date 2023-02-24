<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetAvatarVigneronController extends AbstractController
{
    #[Route('/get/avatar/vigneron', name: 'app_get_avatar_vigneron')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/GetAvatarVigneronController.php',
        ]);
    }
}
