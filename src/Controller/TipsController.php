<?php

namespace App\Controller;

use App\Repository\TipsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TipsController extends AbstractController
{
    #[Route('/tips', name: 'app_tips')]
    public function index(TipsRepository $tipsRepository): Response
    {
        $user = $this->getUser();
        $userId = $user ? $user->getId() : null;

        // Récupération des tips selon leur type
        $consommationTips = $tipsRepository->findBy(['type' => 'consommation']);
        $energieTips = $tipsRepository->findBy(['type' => 'economie']);

        // Transformation des images en base64 si elles sont en BLOB
        foreach ($consommationTips as $tip) {
            $this->convertImageToBase64($tip);
        }

        foreach ($energieTips as $tip) {
            $this->convertImageToBase64($tip);
        }

        // Passer les données au template
        return $this->render('tips/index.html.twig', [
            'consommationTips' => $consommationTips,
            'energieTips' => $energieTips,
            'userID' => $userId,
        ]);
    }

    private function convertImageToBase64($tip)
    {
        // Si l'image est un flux (BLOB), on la transforme en base64 pour l'affichage
        $imageData = $tip->getImage();
        if (is_resource($imageData)) {
            $tip->setImage('data:image/jpeg;base64,' . base64_encode(stream_get_contents($imageData)));
        }
    }
}
