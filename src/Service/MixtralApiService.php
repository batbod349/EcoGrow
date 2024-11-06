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

    public function sendDailyPrompt(string $prompt): array
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

        // Envoi de la requête à l'API
        $response = $this->client->request('POST', 'https://api.infomaniak.com/1/ai/501/openai/chat/completions', [
            'headers' => $headers,
            'json' => $body,
        ]);

        $data = $response->toArray();

        // Extraction du contenu des idées
        $content = $data['choices'][0]['message']['content'];

        // On sépare les idées par les numéros (ici '1.', '2.' et '3.')
        preg_match_all('/\d+\.\s([^\n]+)/', $content, $matches);

        // On retourne un tableau contenant chaque idée sous forme de titre et description
        $ideas = [];
        foreach ($matches[1] ?? [] as $idea) {
            // On sépare le titre de l'idée par un retour à la ligne
            $lines = explode("\n", $idea);
            $title = trim($lines[0] ?? '');  // Le titre est la première ligne
            $description = trim($lines[1] ?? '');  // La description est la deuxième ligne

            // On ajoute le titre et la description dans le tableau
            $ideas[] = [
                'title' => $title,
                'description' => $description,
            ];
        }

        return $ideas;
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
