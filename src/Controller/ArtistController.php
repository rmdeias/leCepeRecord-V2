<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArtistController extends AbstractController
{
    #[Route('/artists', name: 'app_artists')]
    public function index(): Response
    {
        return $this->render('artist/index.html.twig', [

        ]);
    }
}
