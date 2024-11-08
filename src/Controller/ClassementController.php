<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClassementController extends AbstractController
{
    #[Route('/classement', name: 'app_classement')]
    public function index(): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        return $this->render('classement/index.html.twig', [
            'controller_name' => 'ClassementController',
            'userID' => $userId,
        ]);
    }
}
