<?php

namespace App\Controller;

use App\Entity\Vigneron;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class GetAvatarVigneronController extends AbstractController
{
    public function __invoke(Vigneron $data): Response
    {
        $imageName = $data->getContenuImage();
        $imagePath = __DIR__.'/../../public/uploads/img/vigneron/'.$imageName;
        $image = file_get_contents($imagePath);

        return new Response(
            $image,
            Response::HTTP_OK,
            ['Content-Type' => 'image/png']
        );

    }

}
