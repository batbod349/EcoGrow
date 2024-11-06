<?php

namespace App\Command;

use App\Service\MixtralApiService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ApiResponse;

#[AsCommand(
    name: 'DailyApiCommand',
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

        // Appel API via le service
        try {
            $prompt = "Répond en francais uniquement : Donne moi 3 idées de tâches eco-résponsable (en numérotant chaques idées) à réaliser dans la journée";
            $ideas = $this->mixtralApiService->sendPrompt($prompt);

            // Sauvegarde de la réponse dans la base de données
            $apiResponse = new ApiResponse();
            $apiResponse->setStatusCode(200);
            $apiResponse->setData($ideas);
            $apiResponse->setCreatedAt(new \DateTime());

            $this->entityManager->persist($apiResponse);
            $this->entityManager->flush();

            $io->success('API appelée et réponse sauvegardée avec succès.');

        } catch (\Exception $e) {
            $io->error('Exception lors de l\'appel API : ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
