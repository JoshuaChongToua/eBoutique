<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;

final class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(RequestStack $requestStack, ProduitRepository $produitRepository): Response
    {
        $session = $requestStack->getSession();
        $panier = $session->get('panier', []);
        $panierWithData = [];
        $total = 0;

        foreach ($panier as $id => $quantity) {
            $produit = $produitRepository->find($id);
            if ($produit) {
                $panierWithData[] = [
                    'produit' => $produit,
                    'quantity' => $quantity
                ];
                $total += $produit->getPrix() * $quantity;
            }
        }

        return $this->render('panier/index.html.twig', [
            'panier' => $panierWithData,
            'total' => $total
        ]);
    }

    #[Route('/panier/update', name: 'app_panier_update', methods: ['POST'])]
    public function updateQuantity(Request $request, RequestStack $requestStack, ProduitRepository $produitRepository): JsonResponse
    {
        $session = $requestStack->getSession();
        $panier = $session->get('panier', []);

        $id = $request->request->getInt('id');
        $newQuantity = $request->request->getInt('quantity');

        if ($newQuantity < 1) {
            return new JsonResponse(['error' => 'Quantité invalide'], 400);
        }

        if (!isset($panier[$id])) {
            return new JsonResponse(['error' => 'Produit non trouvé'], 404);
        }

        $panier[$id] = $newQuantity;
        $session->set('panier', $panier);

        $total = 0;
        foreach ($panier as $produitId => $quantity) {
            $produit = $produitRepository->find($produitId);
            if ($produit) {
                $total += $produit->getPrix() * $quantity;
            }
        }


        return new JsonResponse([
            'success' => true,
            'newTotal' => $produitRepository->find($id)->getPrix() * $newQuantity,
            'newAllTotal' => $total
        ]);
    }

}
