<?php

namespace App\Controller;

use App\Service\MixtralApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class StartController extends AbstractController
{
    #[Route('/', name: 'app_start')]
    public function index(): Response
    {
        return $this->render('start/index.html.twig', [
            'controller_name' => 'StartController',
        ]);
    }
}
