<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'app_boutique')]
    public function index(ProductRepository $productRepository): Response
    {
        // Récupérer tous les produits depuis la base de données
        $products = $productRepository->findAll();

        // Passer les produits à la vue
        return $this->render('boutique/index.html.twig', [
            'products' => $products,
        ]);
    }

    // Route pour participer
    #[Route('/participer/{id}', name: 'app_participer')]
    public function participer(Product $product, int $id): RedirectResponse
    {
        $user = $this->getUser(); // Supposons qu'il y a un utilisateur connecté
        if ($user) {
            // Ajoutez une action comme l'ajout au panier, le comptage, etc.
            // $user->addToCart($product);
            // Le code dépend de votre logique de panier

            // Optionnel : Flash message pour confirmer l'ajout
            $this->addFlash('success', 'Produit ajouté au panier !');
        }

        // Rediriger vers la boutique ou une autre page de confirmation
        return $this->redirectToRoute('app_boutique');
    }
}
