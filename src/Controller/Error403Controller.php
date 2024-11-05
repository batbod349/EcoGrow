<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Error403Controller extends AbstractController
{
    #[Route('/error403', name: 'app_error403')]
    public function index(): Response
    {
        return $this->render('error403/index.html.twig', [
            'controller_name' => 'Error403Controller',
        ]);
    }
}
