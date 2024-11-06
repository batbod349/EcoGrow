<?php

namespace App\Controller;

use App\Service\MixtralApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class StartController extends AbstractController
{
    #[Route('/start', name: 'app_start')]
    public function index(): Response
    {
        return $this->render('start/index.html.twig', [
            'controller_name' => 'StartController',
        ]);
    }
    public function __construct(private MixtralApiService $mixtralApiService) {}

    #[Route('/fetch-ideas-ajax', name: 'fetch_ideas_ajax', methods: ['POST'])]
    public function fetchIdeasAjax(): JsonResponse
    {
        // Utilisation du service pour récupérer la réponse brute de l'API
        $ideas  = $this->mixtralApiService->sendPrompt("Répond en francais uniquement : Donne moi 3 idées de tâches eco-résponsable (en numérotant chaques idées) à réaliser dans la journée");

        // Retourner les idées sous forme de tableau
        return new JsonResponse(['ideas' => $ideas]);
    }
}
