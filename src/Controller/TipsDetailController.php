<?php

namespace App\Controller;

use App\Repository\TipsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TipsDetailController extends AbstractController
{
    #[Route('/tips/{id}', name: 'app_tips_detail')]
    public function index(int $id, TipsRepository $tipsRepository): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        // Récupérer l'astuce par ID
        $tip = $tipsRepository->find($id);

        // Vérification si l'astuce existe
        if (!$tip) {
            throw $this->createNotFoundException("L'astuce n'existe pas.");
        }

        return $this->render('tips_detail/index.html.twig', [
            'tip' => $tip,
            'userID' => $userId,
        ]);
    }
}
