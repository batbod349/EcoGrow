<?php

namespace App\Command;

use App\Entity\Quest;
use App\Service\MixtralApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:MonthlyApiCommand',
    description: 'Appel l\'API du LLM pour lui demander les tâches mensuel',
)]
class MonthlyApiCommand extends Command
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

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $prompt = "Répond en francais uniquement : Donne moi 3 idées de tâches eco-résponsable  (un peu difficile) (en numérotant chaques idées) à réaliser dans le mois.";
            $ideas = $this->mixtralApiService->sendQuestPrompt($prompt);
            $i = 1;

            foreach ($ideas as $idea) {
                $quest = new Quest();
                $quest->setName('Monthly' . $i);
                $quest->setDescription($idea);  // Utilise directement l'idée comme description
                $quest->setRewards(100);
                $quest->setDate(new \DateTime());
                $quest->setType('Monthly');
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
