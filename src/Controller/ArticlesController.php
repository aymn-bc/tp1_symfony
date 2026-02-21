<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function nouveau(EntityManagerInterface $em): Response 
    {
        $article = new Article();
        $article->setTitre('Mon premier article');
        $article->setAuteur('Etudiant');
        $article->setContenu('Ceci est le contenu de mon premier article créé avec Doctrine.');
        $article->setDateCreation(new \DateTime());
        $article->setPublie(true);

        $em->persist($article); // save it 
        $em->flush(); // execute reqs to insert in db

        return new Response("Article créé avec l'id : " . $article->getId());
    }

    #[Route('articles/{id}', name: 'app_article_detail', requirements: ['id' => '\d+'])]
    public function detail(Article $article): Response
    {
        return $this->render('articles/detail.html.twig', [
            'article'=> $article
        ]);
    }
}
