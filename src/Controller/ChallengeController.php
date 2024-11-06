<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\QuestRepository;

class ChallengeController extends AbstractController
{
    #[Route('/challenge', name: 'app_challenge')]
    public function index(QuestRepository $QuestRepository): Response
    {
        $today = new \datetime();
        $dailyQuests = $QuestRepository->findDailyQuests($today);
        $monthlyQuests = $QuestRepository->findMonthlyQuest($today);
        return $this->render('challenge/index.html.twig',
        [
            'dailyQuests' => $dailyQuests,
            'monthlyQuests' => $monthlyQuests,
        ]);
    }
}
