<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class MixtralApiService
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendQuestPrompt(string $prompt): array
    {
        $headers = [
            'Authorization' => 'Bearer ' . $_ENV['AI_TOOLS_API_KEY'],
            'Content-Type' => 'application/json',
        ];
        $body = [
            'messages' => [
                [
                    'content' => $prompt,
                    'role' => 'user',
                ],
            ],
            'model' => 'mixtral',
        ];
        $response = $this->client->request('POST', 'https://api.infomaniak.com/1/ai/501/openai/chat/completions', [
            'headers' => $headers,
            'json' => $body,
        ]);
        $data = $response->toArray();
        // Extraction du contenu des idées (en enlevant les retours à la ligne et autres caractères inutiles)
        $content = $data['choices'][0]['message']['content'];
        // On sépare les idées par les numéros (ici '1.', '2.' et '3.')
        preg_match_all('/\d+\.\s([^\n]+)/', $content, $matches);
        // Retourne les idées sous forme de tableau
        return $matches[1] ?? [];
    }
    public function sendPrompt(string $prompt): string
    {
        $headers = [
            'Authorization' => 'Bearer ' . $_ENV['AI_TOOLS_API_KEY'],
            'Content-Type' => 'application/json',
        ];

        $body = [
            'messages' => [
                [
                    'content' => $prompt,
                    'role' => 'user',
                ],
            ],
            'model' => 'mixtral',
        ];

        // Envoie la requête POST à l'API avec les en-têtes et le corps
        $response = $this->client->request('POST', 'https://api.infomaniak.com/1/ai/501/openai/chat/completions', [
            'headers' => $headers,
            'json' => $body,
        ]);

        // Convertit la réponse en tableau PHP
        $data = $response->toArray();

        // Extrait et retourne directement le contenu de la réponse de l'API
        return $data['choices'][0]['message']['content'];
    }

}
