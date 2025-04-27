<?php

namespace App\Controller;

use App\Entity\Band;
use App\Repository\BandRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArtistController extends AbstractController
{
    #[Route('/artists', name: 'app_artists')]
    public function index(BandRepository $bandRepository): Response
    {

        $bands = $bandRepository->findAll();
        return $this->render('artist/index.html.twig', [
            'artists' => $bands,
        ]);
    }
    #[Route('/artists/{slug}', name: 'app_artist')]
    public function displayArtist(BandRepository $bandRepository , ProductRepository $productRepository, $slug): Response
    {

        $artist = $bandRepository->findOneBy(['slug' => $slug]);

        // Utiliser l'ID de l'artiste pour récupérer les produits associés
        $products = $productRepository->findBy(['band' => $artist]);


        return $this->render('artist/displayArtist.html.twig', [
            'artist' => $artist,
            'products' => $products,
        ]);
    }
}
