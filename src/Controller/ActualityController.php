<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualityController extends AbstractController
{
    #[Route('/actuality', name: 'app_actuality')]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        $articles = $articlesRepository->findLast10Articles();

        return $this->render('actuality/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/actuality/{id}', name: 'app_actuality_detail')]
    public function detailIndex(int $id, ArticlesRepository $articleRepository): Response
    {
        $article = $articleRepository->fetchArticleById($id);
        return $this->render('actuality/detail.html.twig', [
            'article' => $article,
        ]);
    }
}