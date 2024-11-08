<?php

namespace App\Controller;

use App\Repository\TipsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WideImage\WideImage;

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
        $popularTips = $tipsRepository->findPopularTips();
        $courseTips = $tipsRepository->findCourseTips();
        return $this->render('tips/index.html.twig', [
            'popularTips' => $popularTips,
            'courseTips' => $courseTips,
            'consommationTips' => $consommationTips,
            'energieTips' => $energieTips,
        ]);
    }

    private function convertImageToBase64($tip)
    {
        // Si l'image est un flux (BLOB), on la transforme en base64 pour l'affichage
        $imageData = $tip->getImage();
        
        if (is_resource($imageData)) {
            // Lire l'image depuis le flux (BLOB)
            $imageContent = stream_get_contents($imageData);
    
            // Redimensionner l'image avec WideImage
            $image = WideImage::loadFromString($imageContent);
            $resizedImage = $image->resize(50, 30); // Redimensionner à 50x30 pixels
    
            // Convertir l'image redimensionnée en base64
            $base64Image = base64_encode($resizedImage->asString('png'));
    
            // Sauvegarder l'image redimensionnée en base64
            $tip->setImage('data:image/png;base64,' . $base64Image);
        }
    }
    }
