<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GrowController extends AbstractController
{
    #[Route('/grow', name: 'app_grow')]
    public function index(): Response
    {
        return $this->render('grow/index.html.twig', [
            'controller_name' => 'GrowController',
        ]);
    }
}
