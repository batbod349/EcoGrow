<?php

namespace App\Controller;

use App\Entity\Experiences;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GrowController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    // Injection de l'EntityManagerInterface via le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/grow', name: 'app_grow')]
    public function index(): Response
    {
        // Définis l'ID utilisateur (par exemple, 1 si tu le veux en dur pour l'instant)
        //TODO:: A changer par l'id de l'user log
        $userID = 1;

        // Récupère le mood en appelant getEcopagnonMood
        $moodValue = $this->getEcopagnonMood($userID);

        return $this->render('grow/index.html.twig', [
            'controller_name' => 'GrowController',
            'moodValue' => $moodValue, // Passe moodValue à la vue
        ]);
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

        // Recherche des expériences avec la date d'aujourd'hui pour cet utilisateur
        $experiencesToday = $experienceRepository->findBy([
            'user' => $userID,
            'date' => $today,
        ]);

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

        // Si une expérience existe avec la date d'aujourd'hui, retourne une valeur différente, si nécessaire
        return 1;  // Ou une autre logique selon tes besoins
    }
}
