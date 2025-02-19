<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PageProduitController extends AbstractController
{
    #[Route('/page-produit-index', name: 'app_page_produit')]
    public function index(): Response
    {
        return $this->render('page_produit/index.html.twig', [
            'controller_name' => 'PageProduitController',
        ]);
    }

    #[Route('/page-produit', name: 'app_get_all_produit', methods: ['GET'])]
    public function getAllProduit(ProduitRepository $produitRepository): Response
    {
        return $this->render('page_produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/page-produit/europe', name: 'app_get_europe_produit', methods: ['GET'])]
    public function getEuropeProduit(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->findBy(['nom' => 'europe']);
        return $this->render('page_produit/index.html.twig', [
            'produits' => $produitRepository->findby(['categorie' => $categorie]),
        ]);
    }

    #[Route('/page-produit/asie', name: 'app_get_asie_produit', methods: ['GET'])]
    public function getAsieProduit(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->findBy(['nom' => 'asie']);
        return $this->render('page_produit/index.html.twig', [
            'produits' => $produitRepository->findby(['categorie' => $categorie]),
        ]);
    }
}
