<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'userID' => $userId,
        ]);
    }
}
