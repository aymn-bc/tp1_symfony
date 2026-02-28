<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(): Response
    {
        $articles = [
            ['titre' => 'Introduction à Symfony',   'auteur' => 'Alice',    'publie' => true],
            ['titre' => 'Les bases de Twig',        'auteur' => 'Bob',      'publie' => true],
            ['titre' => 'Doctrine ORM en pratique', 'auteur' => 'Claire',   'publie' => false],
            ['titre' => 'Sécurité avec Symfony',    'auteur' => 'David',    'publie' => true],
            ['titre' => 'API Platform (brouillon)', 'auteur' => 'Eve',      'publie' => false],

        ];
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/articles/nouveau', name: 'app_article_nouveau')]
    public function nouveau(Request $request, EntityManagerInterface $em): Response 
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($article); // save it 
            $em->flush(); // execute reqs to insert in db

            $this->addFlash('success', 'Article créé avec succès !');
    
            return $this->redirectToRoute('app_articles');
        }

        return $this->render('articles/nouveau.html.twig', [ 'formulaire' => $form ]);
    }

    #[Route('articles/{id}', name: 'app_article_detail', requirements: ['id' => '\d+'])]
    public function detail(Article $article): Response
    {
        return $this->render('articles/detail.html.twig', [
            'article'=> $article
        ]);
    }
}
