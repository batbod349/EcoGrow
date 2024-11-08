<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaintenanceController extends AbstractController
{
    #[Route('/maintenance', name: 'app_maintenance')]
    public function index(): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        return $this->render('maintenance/index.html.twig', [
            'controller_name' => 'MaintenanceController',
            'userID' => $userId,
        ]);
    }
}