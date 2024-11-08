<?php

namespace App\Controller;

use App\Repository\ExperiencesRepository;
use App\Repository\FriendsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClassementController extends AbstractController
{
    #[Route('/classement', name: 'app_classement')]
    public function index(UserRepository $userRepository, ExperiencesRepository $experiencesRepository, FriendsRepository $friendsRepository): Response
    {
        $users = $userRepository->findAll();
        $allUsers = [];

        $i = 0;
        foreach ($users as $user) {
            $user->points = 0;
            $user->points += $experiencesRepository->getTotalPoints($user->getId());
            $allUsers[$i] = $user;
            $i++;
        }

        usort($allUsers, function($a, $b) {
            return $b->points <=> $a->points;
        });

        //dd($allUsers);
        $friends = $friendsRepository->getFriends($this->getUser()->getId());
        $friendsPoints = [];
        $friendsPoints[0] = $this->getUser();
        $friendsPoints[0]->points = $experiencesRepository->getTotalPoints($this->getUser()->getId());

        $i = 1;
        foreach ($friends as $friend) {
            if ($friend->getUser1()->getId() === $this->getUser()->getId()) {
                $friend = $friend->getUser2();
            } else {
                $friend = $friend->getUser1();
            }
            $friend->points = 0;
            $friend->points += $experiencesRepository->getTotalPoints($friend->getId());
            $friendsPoints[$i] = $friend;
            $i++;
        }

        usort($friendsPoints, function($a, $b) {
            return $b->points <=> $a->points;
        });

        //dd($friendsPoints);

        return $this->render('classement/index.html.twig', [
            'userID' => $this->getUser()->getId(),
            'friends' => $friendsPoints,
            'users' => $allUsers,
            'controller_name' => 'ClassementController',
        ]);
    }
}
