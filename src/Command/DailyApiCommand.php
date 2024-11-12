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

        try {
            $prompt = "Répond en francais uniquement : Donne moi 3 idées de tâches eco-résponsable (en numérotant chaques idées) à réaliser dans la journée.";
            $ideas = $this->mixtralApiService->sendQuestPrompt($prompt);
            $i = 1;

            foreach ($ideas as $idea) {
                $quest = new Quest();
                $quest->setName('Daily' . $i);
                $quest->setDescription($idea);  // Utilise directement l'idée comme description
                $quest->setRewards(25);
                $quest->setDate(new \DateTime());
                $quest->setType('Daily');
                $i++;

                $this->entityManager->persist($quest);
            }

            $this->entityManager->flush();
            $io->success('Les tâches ont été ajoutées avec succès dans la base de données.');

        } catch (\Exception $e) {
            $io->error('Exception lors de l\'appel API ou de l\'ajout en base de données : ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}