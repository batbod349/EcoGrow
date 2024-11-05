<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ActualityDetailController extends AbstractController
{
    #[Route('/actuality/detail', name: 'app_actuality_detail')]
    public function index(): Response
    {
        return $this->render('actuality_detail/index.html.twig', [
            'controller_name' => 'ActualityDetailController',
        ]);
    }
}
