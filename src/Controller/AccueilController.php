<?php

namespace App\Controller;

use App\Repository\ExperiencesRepository;
use App\Repository\FriendsRepository;
use App\Repository\QuestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(QuestRepository $questRepository, ExperiencesRepository $experiencesRepository, FriendsRepository $friendsRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $today = new \DateTime();
        $dailyQuests = $questRepository->findDailyQuests($today);

        $user = $this->getUser();
        $userId = $user->getId();
        $userPoints = $experiencesRepository->getTotalPoints($userId);
        $userAvailablePointsTemp = $experiencesRepository->findAvailablePoints($userId);
        $userAvailablePoints = 0;
        foreach ($userAvailablePointsTemp as $points) {
            if ($points->isType()) {
                $userAvailablePoints += $points->getQuantity();
            } else {
                $userAvailablePoints -= $points->getQuantity();
            }
        }

        $completedQuests = $experiencesRepository->getCompletedDailyQuests($userId, $today);
        $completedMonthlyQuests = $experiencesRepository->getCompletedMonthlyQuests($userId, $today);

        $friends = $friendsRepository->getFriends($userId);
        $friendsPoints = [];
        foreach ($friends as $friend) {
            $friendEntity = $friend->getUser1();
            if ($friendEntity->getId() === $userId) {
                $friendEntity = $friend->getUser2();
            }
            $friendId = $friendEntity->getId();
            $friendsPoints[$friendId] = $experiencesRepository->getTotalPoints($friendId);
        }

        // Determine the user's position
        $allPoints = [$userId => $userPoints] + $friendsPoints;
        arsort($allPoints);
        $position = array_search($userId, array_keys($allPoints)) + 1;

        // Calculate average points per day over the last 7 days
        $pointsLast7Days = $experiencesRepository->findPointsLast7Days($userId);
        $totalPointsLast7Days = array_sum(array_column($pointsLast7Days, 'totalPoints'));
        $averagePointsPerDay = intval($totalPointsLast7Days / 7);

        return $this->render('accueil/index.html.twig', [
            'dailyQuests' => $dailyQuests,
            'completedQuests' => $completedQuests,
            'completedMonthlyQuests' => $completedMonthlyQuests,
            'monthlyQuests' => $questRepository->findMonthlyQuest($today),
            'user' => $user,
            'userPoints' => $userPoints,
            'friendsPoints' => $friendsPoints,
            'position' => $position,
            'averagePointsPerDay' => $averagePointsPerDay,
            'pointsLast7Days' => $totalPointsLast7Days,
            'availablePoints' => $userAvailablePoints,
        ]);
    }
}