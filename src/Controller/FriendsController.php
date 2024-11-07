<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FriendsController extends AbstractController
{
    #[Route('/friends', name: 'app_friends')]
    public function FriendIndex(): Response
    {
        return $this->render('friends/index.html.twig', [
            'controller_name' => 'FriendsController',
        ]);
    }

    #[Route('/friends/add', name: 'app_add_friends')]
    public function addFriendIndex(): Response
    {
        return $this->render('friends/add_friends.html.twig', [
            'controller_name' => 'AddFriendsController',
        ]);
    }
}
