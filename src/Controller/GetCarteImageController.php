<?php

namespace App\Controller;

use App\Entity\Carte;
use Symfony\Component\HttpFoundation\Response;

class GetCarteImageController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function __invoke(Carte $data): Response
    {
        $imageName = $data->getContenuImage();
        $imagePath = __DIR__.'/../../public/uploads/img/'.$imageName;
        $image = file_get_contents($imagePath);

        return new Response(
            $image,
            Response::HTTP_OK,
            ['Content-Type' => 'image/png']
        );
    }
}
