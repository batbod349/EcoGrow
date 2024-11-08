<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index(): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        return $this->render('notification/index.html.twig', [
            'controller_name' => 'NotificationController',
            'userID' => $userId,
        ]);
    }
}
