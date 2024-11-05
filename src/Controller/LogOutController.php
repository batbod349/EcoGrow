<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogOutController extends AbstractController
{
    #[Route('/log/out', name: 'app_log_out')]
    public function index(): Response
    {
        return $this->render('log_out/index.html.twig', [
            'controller_name' => 'LogOutController',
        ]);
    }
}
