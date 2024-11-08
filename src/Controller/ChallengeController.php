<?php

namespace App\Controller;

use App\Entity\Experiences;
use App\Entity\Quest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\QuestRepository;

class ChallengeController extends AbstractController
{
    #[Route('/challenge', name: 'app_challenge')]
    public function index(QuestRepository $QuestRepository): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $today = new \datetime();
        $dailyQuests = $QuestRepository->findDailyQuests($today);
        $monthlyQuests = $QuestRepository->findMonthlyQuest($today);
        return $this->render('challenge/index.html.twig',
        [
            'dailyQuests' => $dailyQuests,
            'monthlyQuests' => $monthlyQuests,
            'userID' => $userId,
        ]);
    }

    #[Route('/challenge/validate/{id}', name: 'app_challenge_validate')]
    public function validate(Quest $quest, EntityManagerInterface $entityManager, int $id): Response
    {

        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        if ($user->getQuests()->contains($quest)) {
            // Return a response indicating the quest has already been validated
            $this->addFlash('warning', 'You have already validated this quest.');
            return $this->redirectToRoute('app_accueil');
        }
        $user->addQuest($quest);

        $experience = new Experiences();
        $experience->setQuantity($quest->getRewards());
        $experience->setDate(new \DateTime());
        $experience->setType(1); // Assuming type 1 for this case
        $experience->setSource($quest->getType());
        $experience->setUser($this->getUser());
        $experience->setQuest($quest);
        $experience->setCompletedAt(new \DateTime());

        $entityManager->persist($experience);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_accueil');
    }
}
