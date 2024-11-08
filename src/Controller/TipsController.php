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
        // Récupération des tips selon leur type
        $consommationTips = $tipsRepository->findBy(['type' => 'Consommation et Achats Responsables']);
        $energieTips = $tipsRepository->findBy(['type' => 'Économies d’Énergie et Transport Écoresponsable']);

        // Transformation des images en base64 si elles sont en BLOB
        foreach ($consommationTips as $tip) {
            if (is_resource($tip->getImage())) {
                $tip->setImage('data:image/jpeg;base64,' . base64_encode(stream_get_contents($tip->getImage())));
            }
        }

        foreach ($energieTips as $tip) {
            if (is_resource($tip->getImage())) {
                $tip->setImage('data:image/jpeg;base64,' . base64_encode(stream_get_contents($tip->getImage())));
            }
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
}
