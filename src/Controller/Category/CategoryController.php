<?php

namespace App\Controller\Category;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/category', name: 'app_category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', compact('categories'));
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $category = new Category;
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Nouvelle Categorie créée');

            return $this->redirectToRoute('app_category_index');
        }

        return $this->render('category/create.html.twig', compact('form'));
    }
}
