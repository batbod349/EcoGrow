<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IndexTestController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    #[Route('/index/test', name: 'app_index_test')]
    public function index(): Response
    {
        $headers = [
            'Authorization' => 'Bearer ' . $_ENV['AI_TOOLS_API_KEY'],
            'Content-Type' => 'application/json',
        ];

        $body = [
            'messages' => [
                [
                    'content' => 'répond en Français uniquement : comment vas tu ?',
                    'role' => 'user',
                ],
            ],
            'model' => 'mixtral',
        ];

        $response = $this->client->request('POST', 'https://api.infomaniak.com/1/ai/501/openai/chat/completions', [
            'headers' => $headers,
            'json' => $body,
        ]);

        return $this->render('index_test/index.html.twig', [
            'response' => json_encode($response->toArray()), // Convert array to JSON string
        ]);
    }
}