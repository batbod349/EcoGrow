<?php

namespace App\Controller;

use App\Entity\Experiences;
use App\Entity\Product;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    public function shop(ProductRepository $productRepository, UserRepository $userRepository)
    {
        // Récupérer l'utilisateur actuel
        $user = $this->getUser();

        // Récupérer tous les produits
        $products = $productRepository->findAll();

        // Passer les produits à la vue
        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'user' => $user,
        ]);
    }

    // Route pour participer
    #[Route('/participer/{id}', name: 'app_participer')]
    public function participer(Product $product, int $id, EntityManagerInterface $entityManager): RedirectResponse
    {
        $user = $this->getUser(); // Supposons qu'il y a un utilisateur connecté
        if (!$user) {
            // Rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
            // Ajoutez une action comme l'ajout au panier, le comptage, etc.
            // $user->addToCart($product);
            // Le code dépend de votre logique de panier

            // Optionnel : Flash message pour confirmer l'ajout
            //$this->addFlash('success', 'Produit ajouté au panier !');
        }

        // verifier si l'utilisateur est déjà inscrit
        if ($user->getPurchase()->contains($product)) {
            $this->addFlash('warning', 'Vous avez déjà acheté ce produit !');
            return $this->redirectToRoute('app_boutique');
        }

        $pointsToDebit = $product->getPrice(); // Assuming the product price is the points to debit
        $experience = new Experiences();
        $experience->setType(0); // Type 0 for debit
        $experience->setQuantity($pointsToDebit); // Negative points for debit
        $experience->setDate(new \DateTime());
        $experience->setSource('Achat du produit ' . $product->getName());
        $experience->setUser($user);
        $user->addExperience($experience);
        $entityManager->persist($experience);
        $entityManager->persist($user);
        $entityManager->flush();

        $user->addPurchase($product);
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Produit acheté avec succès !');

        // Rediriger vers la boutique ou une autre page de confirmation
        return $this->redirectToRoute('app_boutique');
    }
}
