<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddFriendsController extends AbstractController
{
    #[Route('/add/friends', name: 'app_add_friends')]
    public function index(): Response
    {
        return $this->render('add_friends/index.html.twig', [
            'controller_name' => 'AddFriendsController',
        ]);
    }
}
