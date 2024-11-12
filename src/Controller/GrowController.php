<?php

namespace App\Controller;

use App\Entity\Experiences;
use App\Service\MixtralApiService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GrowController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private MixtralApiService $mixtralApiService;

    // Injection de l'EntityManagerInterface via le constructeur
    public function __construct(MixtralApiService $mixtralApiService, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->mixtralApiService = $mixtralApiService;
    }
    #[Route('/grow', name: 'app_grow')]
    public function index(SessionInterface $session): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        $userID = $user->getId();

        // Récupère l'historique des messages
        $chatHistory = $session->get('chat_history', []);

        // Récupère le mood en appelant getEcopagnonMood
        $moodValue = $this->getEcopagnonMood($userID);

        return $this->render('grow/index.html.twig', [
            'controller_name' => 'GrowController',
            'moodValue' => $moodValue,
            'userID' => $userID,
            'chatHistory' => $chatHistory, // Passe l'historique à la vue
        ]);
    }

    #[Route('/grow/clear-history', name: 'app_clear_chat_history', methods: ['POST'])]
    public function clearChatHistory(SessionInterface $session): Response
    {
        // Supprime l'historique des messages dans la session
        $session->remove('chat_history');
        return $this->json(['status' => 'ok']);
    }

    #[Route('/grow/chatbot', name: 'app_chatbot', methods: ['POST'])]
    public function handleChatBotRequest(Request $request, SessionInterface $session): Response
    {
        $data = json_decode($request->getContent(), true);

        if (isset($data['prompt'])) {
            $prompt = $data['prompt'];

            // Récupère l'historique des messages de la session ou initialise un tableau vide
            $history = $session->get('chat_history', []);

            // Ajoute le message utilisateur à l'historique
            $history[] = ['user' => $prompt];

            // Envoie le message à l'API
            $response = $this->mixtralApiService->sendPrompt($prompt);

            // Ajoute la réponse de l'IA à l'historique
            $history[] = ['ia' => $response];

            // Met à jour la session avec le nouvel historique
            $session->set('chat_history', $history);

            return $this->json(['response' => $response, 'history' => $history]);
        }

        return $this->json(['error' => 'Prompt non fourni'], Response::HTTP_BAD_REQUEST);
    }
    public function getEcopagnonMood(int $userID): int
    {
        // Créer la date d'aujourd'hui
        $today = new DateTime('today');

        // Créer une instance DateTime pour l'heure actuelle
        $now = new DateTime();

        // Vérifier si l'heure actuelle est entre 00h et 05h
        if ($now->format('H') >= 0 && $now->format('H') < 5) {
            return 9;  // Renvoie 9 si l'heure est entre 00h et 05h
        }

        // Vérifier s'il existe une expérience pour l'utilisateur avec la date d'aujourd'hui
        $experienceRepository = $this->entityManager->getRepository(Experiences::class);

        // Recherche des expériences avec la date d'aujourd'hui pour cet utilisateur (en ignorant l'heure)
        $experiencesToday = $experienceRepository->findByDate($userID, $today);


        // Vérifier la somme des quantities pour aujourd'hui
        $totalQuantity = 0;
        foreach ($experiencesToday as $experience) {
            $totalQuantity += $experience->getQuantity(); // Ajout de la quantité
        }

        // Si la somme des quantities est supérieur à 75, renvoie 12
        if ($totalQuantity > 100 && $totalQuantity != 200 && $totalQuantity != 300) {
            return 12; // Sélectionne un élément aléatoire
        }

        // Si la somme des quantities est égale à 100, renvoie 6
        if ($totalQuantity === 100 || $totalQuantity === 200 || $totalQuantity === 300) {
            return 6; // Sélectionne un élément aléatoire
        }

        // Si la somme des quantities est égale à 75, renvoie un nombre entre 8, 10 et 11
        if ($totalQuantity === 75) {
            $choices = [8, 10, 11]; // Les choix possibles
            return $choices[array_rand($choices)]; // Sélectionne un élément aléatoire
        }

        // Si la somme des quantities est égale à 50, renvoie 7
        if ($totalQuantity === 50) {
            return 7; // Renvoie 7 si la somme des quantities est égale à 50
        }

        // Si la somme des quantities est égale à 25, retourne un nombre entre 1, 2 et 4
        if ($totalQuantity === 25) {
            $choices = [1, 2, 4]; // Les choix possibles
            return $choices[array_rand($choices)]; // Sélectionne un élément aléatoire
        }

        // Sinon, vérifier si aucune expérience n'est trouvée avec la date d'aujourd'hui
        if (!$experiencesToday) {
            $choices = [3, 5]; // Les choix possibles
            return $choices[array_rand($choices)]; // Sélectionne un élément aléatoire
        }

        // Error
        return -1;
    }
}
