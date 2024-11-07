<?php

namespace App\Command;

use App\Service\MixtralApiService;
use App\Entity\Quest;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:DailyApiCommand',
    description: 'Appel l\'API du LLM pour lui demander les tâches quotidiennes',
)]
class DailyApiCommand extends Command
{
    private MixtralApiService $mixtralApiService;
    private EntityManagerInterface $entityManager;

    public function __construct(MixtralApiService $mixtralApiService, EntityManagerInterface $entityManager)
    {
        $this->mixtralApiService = $mixtralApiService;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        // Pas besoin d'argument ni d'option pour cette commande
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Appel de l'API via le service
        try {
            $prompt = "Répond en francais uniquement : Donne moi 3 idées de tâches eco-résponsable (en numérotant chaques idées) à réaliser dans la journée, j'aimerais que pour chaque idée tu me donne le titre de l'idée suivis de l'idée";
            $ideas = $this->mixtralApiService->sendDailyPrompt($prompt);

            // Pour chaque idée retournée, créez une nouvelle entrée dans la table Quest
            foreach ($ideas as $idea) {
                $quest = new Quest();
                $quest->setName($idea['title']);  // Le titre de l'idée va dans Name
                $quest->setDescription($idea['description']);  // La description de l'idée va dans Description
                $quest->setRewards(25);  // Rewards définis à 25
                $quest->setDate(new \DateTime());  // Date actuelle
                $quest->setType('Daily');  // Type = 'Daily'

                // Enregistrez la nouvelle entité Quest dans la base de données
                $this->entityManager->persist($quest);
            }

            // Effectue le flush pour enregistrer toutes les entités dans la base de données
            $this->entityManager->flush();

            $io->success('Les tâches ont été ajoutées avec succès dans la base de données.');

        } catch (\Exception $e) {
            $io->error('Exception lors de l\'appel API ou de l\'ajout en base de données : ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
