<?php

namespace App\Controller;

use App\Entity\Animation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetAnimationImageController extends AbstractController
{
    public function __invoke(Animation $data): Response
    {
        $imageName = $data->getContenuImage();
        $imagePath = __DIR__.'/../../public/uploads/img/animation/'.$imageName;
        $image = file_get_contents($imagePath);

        return new Response(
            $image,
            Response::HTTP_OK,
            ['Content-Type' => 'image/png']
        );
    }
}