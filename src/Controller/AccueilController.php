<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\QuestRepository;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(QuestRepository $QuestRepository): Response
    {
        $today = new \datetime();
        $dailyQuests = $QuestRepository->findDailyQuests($today);
        $monthlyQuests = $QuestRepository->findMonthlyQuest($today);
        return $this->render('accueil/index.html.twig', [
            'dailyQuests' => $dailyQuests,
            'monthlyQuests' => $monthlyQuests,
        ]);
    }
}
