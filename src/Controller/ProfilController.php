<?php

namespace App\Controller;

use App\Repository\BadgesRepository;
use App\Repository\FriendsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(FriendsRepository $friendsRepository, BadgesRepository $badgesRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $userBadges = $user->getBadges();
        $badges = $badgesRepository->findAll();
        $friends = $friendsRepository->getFriends($user->getId());

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'userBadges' => $userBadges,
            'badges' => $badges,
            'friends' => $friends,
        ]);
    }
}
