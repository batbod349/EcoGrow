<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexTestController extends AbstractController
{
    #[Route('/index/test', name: 'app_index_test')]
    public function index(): Response
    {
        return $this->render('index_test/index.html.twig', [
            'controller_name' => 'Test',
        ]);
    }
}
