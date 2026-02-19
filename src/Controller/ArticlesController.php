<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(): Response
    {
        $articles = [
            ['title' => 'Introduction à Symfony',   'auteur' => 'Alice',    'public' => true],
            ['title' => 'Les bases de Twig',        'auteur' => 'Bob',      'public' => true],
            ['title' => 'Doctrine ORM en pratique', 'auteur' => 'Claire',   'public' => false],
            ['title' => 'Sécurité avec Symfony',    'auteur' => 'David',    'public' => true],
            ['title' => 'API Platform (brouillon)', 'auteur' => 'Eve',      'public' => false],

        ];
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
