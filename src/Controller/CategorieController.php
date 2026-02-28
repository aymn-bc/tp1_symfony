<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();


        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/nouvelle', name: 'app_categorie_nouvelle')]
    public function nouvelle(Request $request, EntityManagerInterface $em): Response
    {
        $categorie = new Categorie();

        $form = $this->createFormBuilder($categorie)
            ->add('nom', TextType::class, [
                'label' => 'Nom de la categorie',
                'attr' => [
                    'placeholder' => 'Ex: Technologie, Sport...',
                    'class' => 'form-control',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'row' => 4, 
                    'class' => 'form-control'
                ]
            ])
            ->add('enregistre', SubmitType::class, [
                'label' => 'Créer la catégorie',
                'attr' => [
                    'class' => 'btn btn-primary w-100 mt-3'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', 'Catégorie "' . $categorie->getNom() . '"créée !');
            return $this->redirectToRoute('app_categorie');
        }
        return $this->render('categorie/nouvelle.html.twig', [
            'formulaire' => $form
        ]);
    }
}
