<?php

namespace App\Controller;

use App\Repository\FriendsRepository;
use App\Repository\UserRepository;
use App\Repository\BadgesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FriendsController extends AbstractController
{
    #[Route('/friends', name: 'app_friends')]
    public function friendIndex(FriendsRepository $friendsRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Utilisateur non authentifié.');
        }

        $friends = $friendsRepository->getFriends($user->getId());

        return $this->render('friends/index.html.twig', [
            'friends' => $friends,
        ]);
    }

    #[Route('/friends/add', name: 'app_add_friends')]
    public function addFriendIndex(): Response
    {
        return $this->render('friends/add_friends.html.twig', [
            'controller_name' => 'AddFriendsController',
        ]);
    }

    #[Route('/friends/{id}', name: 'friend_details')]
    public function show(int $id, UserRepository $userRepository, BadgesRepository $badgesRepository): Response
    {
        $friend = $userRepository->find($id);

        if (!$friend) {
            throw $this->createNotFoundException("L'ami avec l'ID $id n'existe pas.");
        }

        // Récupérer les badges de l'ami
        $friendBadges = $friend->getBadges();
        $badges = $badgesRepository->findAll();

        return $this->render('friends/details.html.twig', [
            'friend' => $friend,
            'friendBadges' => $friendBadges,
            'badges' => $badges,
        ]);
    }
}
