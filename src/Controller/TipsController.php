<?php

namespace App\Controller;

use App\Repository\TipsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TipsController extends AbstractController
{
    #[Route('/tips', name: 'app_tips')]
    public function index(TipsRepository $tipsRepository): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $popularTips = $tipsRepository->findPopularTips();
        $courseTips = $tipsRepository->findCourseTips();
        return $this->render('tips/index.html.twig', [
            'popularTips' => $popularTips,
            'courseTips' => $courseTips,
            'userID' => $userId,
        ]);
    }
}
