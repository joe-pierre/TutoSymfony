<?php

namespace App\Controller\Recipe;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/recipes', name: 'app_recipe_')]
class RecipeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        // $recipes = $recipeRepository->findRecipesWhereDurationLowerThan(5);
        
        return $this->render('recipe/index.html.twig', compact('recipes'));
    }

    #[Route(
        '/add-recipe', 
        name: 'create',
    )]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $recipe = new Recipe;
        
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugger = new AsciiSlugger();

            if ($recipe->getTitle() != null || $recipe->getTitle() != '') {
                 $recipe->setSlug($slugger->slug($recipe->getTitle()));
            }
            
            $em->persist($recipe);
            $em->flush();

            $this->addFlash('success', 'La recette à bien été publiée');

            return $this->redirectToRoute('app_recipe_index');
        }
        
        return $this->render('recipe/create.html.twig', compact('form'));
    }

    #[Route(
        '/recipe/{slug}-{id}', 
        name: 'show', 
        requirements: [
            'slug' => Requirement::ASCII_SLUG,
            'id' => Requirement::DIGITS,
        ],
    )]
    public function show(Recipe $recipe, string $slug): Response
    {
        if ($recipe->getSlug() != $slug) {
            return $this->redirectToRoute('app_recipe_show', ['slug' => $recipe->getSlug()]);
        }

        return $this->render('recipe/show.html.twig', compact('recipe'));
    }

    #[Route(
        '/recipe/{id}/edit', 
        name: 'edit', 
        requirements: [
            'id' => '[0-9]+',
        ],
        methods: ['GET', 'POST'],
    )]
    public function edit(Request $request, Recipe $recipe, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_recipe_index');
        }

        return $this->render('recipe/create.html.twig', compact('form'));
    }

    #[Route('/recipe/{id}', 
        name:'delete', 
        methods: ['DELETE'],
    )]
    public function delete(Recipe $recipe, Request $request, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('delete' . $recipe->getId(), $request->getPayload()->get('_token'))) {
            $em->remove($recipe);
            $em->flush();

            $this->addFlash('warning', 'La recette à bien été supprimée');

            return $this->redirectToRoute('app_recipe_index');
        }

        return $this->redirectToRoute('app_recipe_index');
    }
}
