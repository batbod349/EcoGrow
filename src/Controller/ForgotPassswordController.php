<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ForgotPassswordController extends AbstractController
{
    #[Route('/forgot/passsword', name: 'app_forgot_passsword')]
    public function index(): Response
    {
        return $this->render('forgot_passsword/index.html.twig', [
            'controller_name' => 'ForgotPassswordController',
        ]);
    }
}
