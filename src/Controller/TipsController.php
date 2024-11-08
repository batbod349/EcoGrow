<?php

namespace App\Controller;

use App\Repository\TipsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TipsController extends AbstractController
{
    #[Route('/tips', name: 'app_tips')]
    public function index(TipsRepository $tipsRepository): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        // Récupération des tips selon leur type
        $consommationTips = $tipsRepository->findBy(['type' => 'Consommation et Achats Responsables']);
        $energieTips = $tipsRepository->findBy(['type' => 'Économies d’Énergie et Transport Écoresponsable']);
        
        // Passer les données au template
        return $this->render('tips/index.html.twig', [
            'consommationTips' => $consommationTips,
            'energieTips' => $energieTips,
            'userID' => $userId,
        ]);
    }
}
