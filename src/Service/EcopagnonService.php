<?php
namespace App\Service;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ExperiencesRepository;

class EcopagnonService
{
    private $entityManager;
    private $experienceRepository;

    public function __construct(EntityManagerInterface $entityManager, ExperiencesRepository $experienceRepository)
    {
        $this->entityManager = $entityManager;
        $this->experienceRepository = $experienceRepository;
    }

    public function getEcopagnonMood(int $userID): int
    {
        // Logique de la fonction getEcopagnonMood
        $today = new DateTime('today');
        $now = new DateTime();

        if ($now->format('H') >= 0 && $now->format('H') < 5) {
            return 9;
        }

        $experiencesToday = $this->experienceRepository->findByDate($userID, $today);

        $totalQuantity = 0;
        foreach ($experiencesToday as $experience) {
            $totalQuantity += $experience->getQuantity();
        }

        if ($totalQuantity > 100 && $totalQuantity != 200 && $totalQuantity != 300) {
            return 12;
        }

        if ($totalQuantity === 100 || $totalQuantity === 200 || $totalQuantity === 300) {
            return 6;
        }

        if ($totalQuantity === 75) {
            $choices = [8, 10, 11];
            return $choices[array_rand($choices)];
        }

        if ($totalQuantity === 50) {
            return 7;
        }

        if ($totalQuantity === 25) {
            $choices = [1, 2, 4];
            return $choices[array_rand($choices)];
        }

        if (!$experiencesToday) {
            $choices = [3, 5];
            return $choices[array_rand($choices)];
        }

        return -1;
    }
}
