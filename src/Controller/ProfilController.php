<?php
namespace App\Controller;

use App\Form\ProfilEditType;
use App\Repository\BadgesRepository;
use App\Repository\FriendsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
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
        $userBadge = [];
        $i = 0;
        foreach ($userBadges as $badge) {
            // This will initialize the collection
            $userBadge[$i] = $badge;
            $i++;
        }
        $badges = $badgesRepository->findAll();
        $friends = $friendsRepository->getFriends($user->getId());

        //dd($userBadge);

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'userBadges' => $userBadge,
            'badges' => $badges,
            'friends' => $friends,
        ]);
    }

    #[Route('/profil/edit', name: 'app_profil_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        $form = $this->createForm(ProfilEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $profilePictureFile */
            $profilePictureFile = $form->get('profilePicture')->getData();
            if ($profilePictureFile) {
                try {
                    $imageData = file_get_contents($profilePictureFile->getPathname());
                    $user->setPicture($imageData);
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }
            }
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/edit.html.twig', [
            'userID' => $this->getUser()->getId(),
            'ProfilEdit' => $form->createView(),
        ]);
    }
}
