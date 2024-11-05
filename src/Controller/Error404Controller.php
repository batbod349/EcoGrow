<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Error404Controller extends AbstractController
{
    #[Route('/e/error404', name: 'app_e_error404')]
    public function index(): Response
    {
        return $this->render('e_error404/index.html.twig', [
            'controller_name' => 'EError404Controller',
        ]);
    }
}
