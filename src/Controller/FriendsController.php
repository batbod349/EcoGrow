<?php

namespace App\Controller;

use App\Entity\Friends;
use App\Repository\FriendsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BadgesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FriendsController extends AbstractController
{
    #[Route('/friends', name: 'app_friends')]
    public function friendIndex(FriendsRepository $friendsRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $userId = $user->getId();
        $friends = $friendsRepository->getFriends($userId);
        //dd($friends);


        return $this->render('friends/index.html.twig', [
            'userid' => $userId,
            'friends' => $friends,
            'controller_name' => 'FriendsController',
        ]);
    }

    #[Route('/friends/add', name: 'app_add_friends')]
    public function addFriendIndex(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $currentUserId = $this->getUser()->getId();
        return $this->render('friends/add_friends.html.twig', [
            'currentUserId' => $currentUserId,
            'users' => $users,
        ]);
    }

    #[Route('/friends/add/{id}', name: 'app_add_friends_by_id')]
    public function addFriendById(int $id, UserRepository $userRepository, FriendsRepository $friendsRepository, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        $friendUser = $userRepository->find($id);

        if (!$friendUser) {
            throw $this->createNotFoundException('User not found');
        }

        if ($friendsRepository->isFriendshipExists($currentUser->getId(), $friendUser->getId())) {
            $this->addFlash('error', 'You are already friends with this user.');
            return $this->redirectToRoute('app_add_friends');
        }

        $FriendsShipExist = $friendsRepository->isFriendshipRequest($currentUser->getId(), $friendUser->getId());
        if ($FriendsShipExist) {
            if ($FriendsShipExist->getUser1()->getId() == $currentUser->getId()) {
                $this->addFlash('error', 'You already sent a friend request to this user.');
                return $this->redirectToRoute('app_add_friends');
            } else {
                $friendsRepository->acceptFriendship($currentUser->getId(), $friendUser->getId());
                $this->addFlash('success', 'Friend request accepted.');
                return $this->redirectToRoute('app_friends');
            }
        }

        $friend = new Friends();
        $friend->setUser1($currentUser);
        $friend->setUser2($friendUser);
        $friend->setAccepted(false);

        $entityManager->persist($friend);
        $entityManager->flush();

        return $this->redirectToRoute('app_friends');
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
