<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TipsDetailController extends AbstractController
{
    #[Route('/tips/detail', name: 'app_tips_detail')]
    public function index(): Response
    {
        return $this->render('tips_detail/index.html.twig', [
            'controller_name' => 'TipsDetailController',
        ]);
    }
}
